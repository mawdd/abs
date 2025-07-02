<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceLocation;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    private AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Display attendance page
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        
        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();
            
        // Get attendance locations
        $locations = AttendanceLocation::where('is_active', true)->get();
        $primaryLocation = AttendanceLocation::where('is_primary', true)->first();
        
        return view('teacher.attendance.index', compact(
            'todayAttendance', 
            'locations', 
            'primaryLocation'
        ));
    }

    /**
     * Handle check-in
     */
    public function checkIn(Request $request)
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            
            // Validate user is still authenticated and active
            if (!$user || $user->role !== 'teacher' || !$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session tidak valid. Silakan login ulang.',
                    'redirect' => true,
                    'redirect_url' => route('login')
                ], 401);
            }
            
            // Check if already checked in
            $existingAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();
                
            if ($existingAttendance && $existingAttendance->check_in_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan check-in hari ini'
                ]);
            }
            
            // Get location data
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $notes = $request->input('notes', '');
            
            // Validate location
            $locationValidation = $this->validateLocation($latitude, $longitude);
            $primaryLocation = AttendanceLocation::where('is_primary', true)->first();
            
            // Check if location is valid OR admin override is requested
            $adminOverride = $this->isAdminOverride($request);
            
            if (!$locationValidation['valid'] && !$adminOverride) {
                \Log::warning('Teacher check-in outside valid area', [
                    'user_id' => $user->id,
                    'user_location' => ['lat' => $latitude, 'lng' => $longitude],
                    'distance' => $locationValidation['distance'],
                    'allowed_radius' => $locationValidation['allowed_radius']
                ]);
                
                // Return warning but allow admin override
                return response()->json([
                    'success' => false,
                    'message' => $locationValidation['message'] . ' (Jarak: ' . $locationValidation['distance'] . 'm, Max: ' . $locationValidation['allowed_radius'] . 'm)',
                    'location_validation' => $locationValidation,
                    'allow_override' => auth()->user()->role === 'admin' // Admin can override
                ]);
            }
            
            // Log admin override if used
            if ($adminOverride) {
                \Log::info('Admin override used for check-in', [
                    'user_id' => $user->id,
                    'admin_id' => auth()->id(),
                    'distance' => $locationValidation['distance']
                ]);
            }
            
            // Create or update attendance
            $attendanceData = [
                'user_id' => $user->id,
                'date' => $today,
                'check_in_time' => now(),
                'check_in_location' => json_encode([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'timestamp' => now()->timestamp
                ]),
                'check_in_location_valid' => $locationValidation['valid'],
                'notes' => $notes,
                'status' => 'present',
            ];
            
            if ($existingAttendance) {
                $existingAttendance->update($attendanceData);
                $attendance = $existingAttendance;
            } else {
                $attendance = Attendance::create($attendanceData);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'attendance' => $attendance,
                'location_validation' => $locationValidation,
                'debug' => [
                    'user_location' => ['lat' => $latitude, 'lng' => $longitude],
                    'school_location' => $primaryLocation ? ['lat' => $primaryLocation->latitude, 'lng' => $primaryLocation->longitude] : null,
                    'calculated_distance' => $locationValidation['distance'] ?? null,
                    'max_radius' => $locationValidation['allowed_radius'] ?? null,
                    'is_valid_backend' => $locationValidation['valid']
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Check-in error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.'
            ], 500);
        }
    }

    /**
     * Handle check-out
     */
    public function checkOut(Request $request)
    {
        try {
            $user = Auth::user();
            $today = Carbon::today();
            
            // Validate user is still authenticated and active
            if (!$user || $user->role !== 'teacher' || !$user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session tidak valid. Silakan login ulang.',
                    'redirect' => true,
                    'redirect_url' => route('login')
                ], 401);
            }
            
            // Get today's attendance
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $today)
                ->first();
                
            if (!$attendance || !$attendance->check_in_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan check-in hari ini'
                ]);
            }
            
            if ($attendance->check_out_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan check-out hari ini'
                ]);
            }
            
            // Get location data
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $notes = $request->input('notes', '');
            
            // Validate location
            $locationValidation = $this->validateLocation($latitude, $longitude);
            $primaryLocation = AttendanceLocation::where('is_primary', true)->first();
            
            // Check if location is valid OR admin override is requested
            $adminOverride = $this->isAdminOverride($request);
            
            if (!$locationValidation['valid'] && !$adminOverride) {
                \Log::warning('Teacher check-out outside valid area', [
                    'user_id' => $user->id,
                    'user_location' => ['lat' => $latitude, 'lng' => $longitude],
                    'distance' => $locationValidation['distance'],
                    'allowed_radius' => $locationValidation['allowed_radius']
                ]);
                
                // Return warning but allow admin override
                return response()->json([
                    'success' => false,
                    'message' => $locationValidation['message'] . ' (Jarak: ' . $locationValidation['distance'] . 'm, Max: ' . $locationValidation['allowed_radius'] . 'm)',
                    'location_validation' => $locationValidation,
                    'allow_override' => auth()->user()->role === 'admin' // Admin can override
                ]);
            }
            
            // Log admin override if used
            if ($adminOverride) {
                \Log::info('Admin override used for check-out', [
                    'user_id' => $user->id,
                    'admin_id' => auth()->id(),
                    'distance' => $locationValidation['distance']
                ]);
            }
            
            // Update attendance
            $attendance->update([
                'check_out_time' => now(),
                'check_out_location' => json_encode([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'timestamp' => now()->timestamp
                ]),
                'check_out_location_valid' => $locationValidation['valid'],
                'notes' => $notes ? $attendance->notes . "\n" . $notes : $attendance->notes,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Check-out berhasil!',
                'attendance' => $attendance,
                'location_validation' => $locationValidation,
                'debug' => [
                    'user_location' => ['lat' => $latitude, 'lng' => $longitude],
                    'school_location' => $primaryLocation ? ['lat' => $primaryLocation->latitude, 'lng' => $primaryLocation->longitude] : null,
                    'calculated_distance' => $locationValidation['distance'] ?? null,
                    'max_radius' => $locationValidation['allowed_radius'] ?? null,
                    'is_valid_backend' => $locationValidation['valid']
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Check-out error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.'
            ], 500);
        }
    }

    /**
     * Show attendance history
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $month = $request->input('month', now()->format('Y-m'));
        
        $attendances = Attendance::where('user_id', $user->id)
            ->whereMonth('date', Carbon::parse($month)->month)
            ->whereYear('date', Carbon::parse($month)->year)
            ->orderBy('date', 'desc')
            ->get();
            
        return view('teacher.attendance.history', compact('attendances', 'month'));
    }

    /**
     * Validate GPS location
     */
    private function validateLocation($latitude, $longitude): array
    {
        if (!$latitude || !$longitude) {
            return [
                'valid' => false,
                'message' => 'Data lokasi tidak valid',
                'distance' => null
            ];
        }
        
        $primaryLocation = AttendanceLocation::where('is_primary', true)->first();
        
        if (!$primaryLocation) {
            return [
                'valid' => true, // Allow if no location configured
                'message' => 'Lokasi tidak dikonfigurasi',
                'distance' => null
            ];
        }
        
        // Calculate distance using Haversine formula
        $distance = $this->calculateDistance(
            $latitude, 
            $longitude, 
            $primaryLocation->latitude, 
            $primaryLocation->longitude
        );
        
        $isValid = $distance <= $primaryLocation->radius_meters;
        
        return [
            'valid' => $isValid,
            'distance' => round($distance, 2),
            'allowed_radius' => $primaryLocation->radius_meters,
            'message' => $isValid ? 'Lokasi valid' : 'Anda berada di luar area yang diizinkan'
        ];
    }

    /**
     * Calculate distance between two GPS coordinates (in meters)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // Earth radius in meters
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
             sin($dLon/2) * sin($dLon/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }

    /**
     * Check if admin override is requested and valid
     */
    private function isAdminOverride($request): bool
    {
        return $request->header('X-Admin-Override') === 'true' && 
               $request->input('admin_override') === true &&
               auth()->user()->role === 'admin';
    }
} 