<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function status(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $isRegistered = $this->attendanceService->isDeviceRegistered($user->id, $request);
        
        return response()->json([
            'success' => true,
            'attendance' => $attendance,
            'device_registered' => $isRegistered,
            'can_check_in' => !$attendance && $isRegistered,
            'can_check_out' => $attendance && !$attendance->check_out_time && $isRegistered,
        ]);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $result = $this->attendanceService->checkIn(
                $request->user(),
                $request->latitude,
                $request->longitude,
                $request
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('attendance.check_in_success'),
                'attendance' => $result,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $result = $this->attendanceService->checkOut(
                $request->user(),
                $request->latitude,
                $request->longitude
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('attendance.check_out_success'),
                'attendance' => $result,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function history(Request $request)
    {
        $user = $request->user();
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 15);

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'attendances' => $attendances,
        ]);
    }

    public function registerDevice(Request $request)
    {
        try {
            $result = $this->attendanceService->registerDevice($request->user()->id, $request);

            return response()->json([
                'success' => true,
                'message' => __('attendance.device_registered_success'),
                'device_registration' => $result,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
} 