<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLocation;
use App\Models\DeviceRegistration;
use App\Models\Holiday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceService
{
    /**
     * Generate device signature from request.
     */
    public function generateDeviceSignature(Request $request): string
    {
        $userAgent = $request->userAgent() ?? 'unknown';
        $acceptLanguage = $request->header('Accept-Language', 'en');
        $acceptEncoding = $request->header('Accept-Encoding', '');
        
        // Create a unique signature based on browser characteristics
        return hash('sha256', $userAgent . $acceptLanguage . $acceptEncoding);
    }
    
    /**
     * Validate device for attendance.
     */
    public function validateDevice(User $user, Request $request): array
    {
        $deviceSignature = $this->generateDeviceSignature($request);
        
        // Check if user has any registered devices
        $existingDevice = $user->deviceRegistrations()
            ->where('device_identifier', $deviceSignature)
            ->where('is_active', true)
            ->first();
            
        if ($existingDevice) {
            // Update last used time
            $existingDevice->update(['last_used_at' => now()]);
            return ['valid' => true, 'device' => $existingDevice];
        }
        
        // Check if user has other active devices
        $hasOtherDevices = $user->deviceRegistrations()->where('is_active', true)->exists();
        
        if ($hasOtherDevices) {
            return [
                'valid' => false, 
                'message' => __('attendance.device_not_registered'),
                'device_signature' => $deviceSignature
            ];
        }
        
        // First time login - register device automatically
        $newDevice = $this->registerDevice($user, $request);
        
        return ['valid' => true, 'device' => $newDevice, 'first_time' => true];
    }
    
    /**
     * Register a new device for user.
     */
    public function registerDevice(User $user, Request $request): DeviceRegistration
    {
        $deviceSignature = $this->generateDeviceSignature($request);
        
        // Deactivate any existing devices
        $user->deviceRegistrations()->update(['is_active' => false]);
        
        return DeviceRegistration::create([
            'user_id' => $user->id,
            'device_identifier' => $deviceSignature,
            'device_details' => [
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
                'accept_language' => $request->header('Accept-Language'),
                'accept_encoding' => $request->header('Accept-Encoding'),
            ],
            'is_active' => true,
            'last_used_at' => now(),
            'approved_at' => now(), // Auto-approve for first device
        ]);
    }
    
    /**
     * Validate GPS location against allowed locations.
     */
    public function validateLocation(?array $location): array
    {
        if (!$location || !isset($location['latitude']) || !isset($location['longitude'])) {
            return ['valid' => false, 'message' => 'Location data is required'];
        }
        
        $primaryLocation = AttendanceLocation::getPrimaryLocation();
        
        if (!$primaryLocation) {
            return ['valid' => false, 'message' => 'No attendance location configured'];
        }
        
        $isWithinRadius = $primaryLocation->isWithinRadius(
            (float) $location['latitude'],
            (float) $location['longitude']
        );
        
        $distance = $primaryLocation->distanceToCoordinates(
            (float) $location['latitude'],
            (float) $location['longitude']
        );
        
        return [
            'valid' => $isWithinRadius,
            'distance' => round($distance, 2),
            'allowed_radius' => $primaryLocation->radius_meters,
            'location' => $primaryLocation,
            'message' => $isWithinRadius ? 'Location valid' : __('attendance.location_warning')
        ];
    }
    
    /**
     * Check if today is a holiday.
     */
    public function isHolidayToday(): array
    {
        $today = Carbon::today();
        $holiday = Holiday::forDate($today->toDateString())->first();
        
        if ($holiday) {
            return [
                'is_holiday' => true,
                'holiday' => $holiday,
                'message' => __('attendance.holiday_notice', ['holiday' => $holiday->title])
            ];
        }
        
        return ['is_holiday' => false];
    }
    
    /**
     * Process daily check-in.
     */
    public function checkIn(User $user, Request $request): array
    {
        // Validate device
        $deviceValidation = $this->validateDevice($user, $request);
        if (!$deviceValidation['valid']) {
            return $deviceValidation;
        }
        
        // Check if already checked in today
        $today = Carbon::today();
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
            
        if ($existingAttendance && $existingAttendance->check_in_time) {
            return [
                'success' => false,
                'message' => __('attendance.already_checked_in')
            ];
        }
        
        // Validate location
        $location = $request->input('location');
        $locationValidation = $this->validateLocation($location);
        
        // Check holiday
        $holidayCheck = $this->isHolidayToday();
        
        // Create or update attendance record
        $attendanceData = [
            'user_id' => $user->id,
            'date' => $today,
            'check_in_time' => now(),
            'check_in_location' => $location,
            'check_in_location_valid' => $locationValidation['valid'],
            'check_in_device_info' => $deviceValidation['device']->device_identifier,
            'is_holiday' => $holidayCheck['is_holiday'],
            'status' => 'present',
        ];
        
        if ($existingAttendance) {
            $existingAttendance->update($attendanceData);
            $attendance = $existingAttendance;
        } else {
            $attendance = Attendance::create($attendanceData);
        }
        
        $result = [
            'success' => true,
            'message' => __('attendance.checked_in_successfully'),
            'attendance' => $attendance,
            'location_validation' => $locationValidation,
        ];
        
        if ($holidayCheck['is_holiday']) {
            $result['holiday_notice'] = $holidayCheck['message'];
        }
        
        return $result;
    }
    
    /**
     * Process daily check-out.
     */
    public function checkOut(User $user, Request $request): array
    {
        // Validate device
        $deviceValidation = $this->validateDevice($user, $request);
        if (!$deviceValidation['valid']) {
            return $deviceValidation;
        }
        
        // Check if checked in today
        $today = Carbon::today();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();
            
        if (!$attendance || !$attendance->check_in_time) {
            return [
                'success' => false,
                'message' => __('attendance.must_check_in_first')
            ];
        }
        
        if ($attendance->check_out_time) {
            return [
                'success' => false,
                'message' => 'You have already checked out today'
            ];
        }
        
        // Validate location
        $location = $request->input('location');
        $locationValidation = $this->validateLocation($location);
        
        // Update attendance record
        $attendance->update([
            'check_out_time' => now(),
            'check_out_location' => $location,
            'check_out_location_valid' => $locationValidation['valid'],
            'check_out_device_info' => $deviceValidation['device']->device_identifier,
        ]);
        
        return [
            'success' => true,
            'message' => __('attendance.checked_out_successfully'),
            'attendance' => $attendance,
            'location_validation' => $locationValidation,
        ];
    }
} 