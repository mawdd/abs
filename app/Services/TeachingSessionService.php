<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\TeachingSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeachingSessionService
{
    protected AttendanceService $attendanceService;
    
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * Start a new teaching session.
     */
    public function startSession(User $teacher, Request $request): array
    {
        // Validate device
        $deviceValidation = $this->attendanceService->validateDevice($teacher, $request);
        if (!$deviceValidation['valid']) {
            return $deviceValidation;
        }
        
        // Check if teacher has an active session
        $activeSession = TeachingSession::where('teacher_id', $teacher->id)
            ->where('status', 'active')
            ->first();
            
        if ($activeSession) {
            return [
                'success' => false,
                'message' => 'You already have an active teaching session'
            ];
        }
        
        // Validate location
        $location = $request->input('location');
        $locationValidation = $this->attendanceService->validateLocation($location);
        
        // Create teaching session
        $session = TeachingSession::create([
            'teacher_id' => $teacher->id,
            'subject_id' => $request->input('subject_id'),
            'class_room_id' => $request->input('class_room_id'),
            'date' => Carbon::today(),
            'start_time' => now(),
            'start_location' => $location,
            'start_location_valid' => $locationValidation['valid'],
            'start_device_info' => $deviceValidation['device']->device_identifier,
            'status' => 'active',
        ]);
        
        return [
            'success' => true,
            'message' => __('attendance.session_started'),
            'session' => $session,
            'location_validation' => $locationValidation,
        ];
    }
    
    /**
     * End a teaching session.
     */
    public function endSession(TeachingSession $session, Request $request): array
    {
        // Validate device
        $deviceValidation = $this->attendanceService->validateDevice($session->teacher, $request);
        if (!$deviceValidation['valid']) {
            return $deviceValidation;
        }
        
        if ($session->status !== 'active') {
            return [
                'success' => false,
                'message' => 'Session is not active'
            ];
        }
        
        // Validate location
        $location = $request->input('location');
        $locationValidation = $this->attendanceService->validateLocation($location);
        
        // Update session
        $session->update([
            'end_time' => now(),
            'end_location' => $location,
            'end_location_valid' => $locationValidation['valid'],
            'end_device_info' => $deviceValidation['device']->device_identifier,
            'status' => 'completed',
        ]);
        
        return [
            'success' => true,
            'message' => __('attendance.session_ended'),
            'session' => $session,
            'location_validation' => $locationValidation,
        ];
    }
    
    /**
     * Save student attendance for a session.
     */
    public function saveStudentAttendance(TeachingSession $session, array $attendanceData): array
    {
        if ($session->status !== 'active') {
            return [
                'success' => false,
                'message' => 'Can only mark attendance for active sessions'
            ];
        }
        
        $savedCount = 0;
        
        foreach ($attendanceData as $studentId => $data) {
            StudentAttendance::updateOrCreate(
                [
                    'teaching_session_id' => $session->id,
                    'student_id' => $studentId,
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                ]
            );
            $savedCount++;
        }
        
        return [
            'success' => true,
            'message' => __('attendance.attendance_saved'),
            'saved_count' => $savedCount,
        ];
    }
    
    /**
     * Get students for a classroom.
     */
    public function getStudentsForClass(int $classRoomId): array
    {
        $students = Student::where('class_room_id', $classRoomId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return $students->toArray();
    }
    
    /**
     * Get session with student attendance.
     */
    public function getSessionWithAttendance(int $sessionId): ?TeachingSession
    {
        return TeachingSession::with([
            'studentAttendances.student',
            'subject',
            'classRoom',
            'teacher'
        ])->find($sessionId);
    }
} 