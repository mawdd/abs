<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\TeachingSession;
use App\Services\TeachingSessionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeachingSessionController extends Controller
{
    protected TeachingSessionService $teachingSessionService;
    
    public function __construct(TeachingSessionService $teachingSessionService)
    {
        $this->teachingSessionService = $teachingSessionService;
    }
    
    /**
     * Get current active session
     */
    public function currentSession(Request $request)
    {
        $user = $request->user();
        
        $activeSession = TeachingSession::with(['subject', 'classRoom'])
            ->where('teacher_id', $user->id)
            ->where('status', 'active')
            ->first();
            
        return response()->json([
            'success' => true,
            'session' => $activeSession,
            'has_active_session' => $activeSession !== null,
        ]);
    }
    
    /**
     * Get teacher's subjects and classes for session setup
     */
    public function getSessionOptions(Request $request)
    {
        $user = $request->user();
        
        // Get subjects assigned to this teacher
        $subjects = [];
        if ($user->teacherProfile) {
            $subjects = $user->teacherProfile->subjects()->get();
        }
        
        // Get all active classrooms
        $classRooms = ClassRoom::all();
        
        return response()->json([
            'success' => true,
            'subjects' => $subjects,
            'class_rooms' => $classRooms,
        ]);
    }
    
    /**
     * Start a teaching session
     */
    public function startSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'class_room_id' => 'required|exists:class_rooms,id',
            'location' => 'required|array',
            'location.latitude' => 'required|numeric|between:-90,90',
            'location.longitude' => 'required|numeric|between:-180,180',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $result = $this->teachingSessionService->startSession($request->user(), $request);
        
        $statusCode = $result['success'] ? 200 : 400;
        
        return response()->json($result, $statusCode);
    }
    
    /**
     * End a teaching session
     */
    public function endSession(Request $request, int $sessionId)
    {
        $validator = Validator::make($request->all(), [
            'location' => 'required|array',
            'location.latitude' => 'required|numeric|between:-90,90',
            'location.longitude' => 'required|numeric|between:-180,180',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $session = TeachingSession::findOrFail($sessionId);
        
        // Check if user owns this session
        if ($session->teacher_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $result = $this->teachingSessionService->endSession($session, $request);
        
        $statusCode = $result['success'] ? 200 : 400;
        
        return response()->json($result, $statusCode);
    }
    
    /**
     * Get students for a session
     */
    public function getStudents(Request $request, int $sessionId)
    {
        $session = TeachingSession::with(['classRoom', 'studentAttendances.student'])
            ->findOrFail($sessionId);
            
        // Check if user owns this session
        if ($session->teacher_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $students = $this->teachingSessionService->getStudentsForClass($session->class_room_id);
        
        // Add current attendance status
        $attendanceMap = $session->studentAttendances->keyBy('student_id');
        
        foreach ($students as &$student) {
            $attendance = $attendanceMap->get($student['id']);
            $student['attendance_status'] = $attendance ? $attendance->status : null;
            $student['attendance_notes'] = $attendance ? $attendance->notes : null;
        }
        
        return response()->json([
            'success' => true,
            'session' => $session,
            'students' => $students,
        ]);
    }
    
    /**
     * Save student attendance
     */
    public function saveStudentAttendance(Request $request, int $sessionId)
    {
        $validator = Validator::make($request->all(), [
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,sick,absent_with_permission,absent_without_permission',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $session = TeachingSession::findOrFail($sessionId);
        
        // Check if user owns this session
        if ($session->teacher_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Transform attendance data
        $attendanceData = [];
        foreach ($request->input('attendance') as $attendance) {
            $attendanceData[$attendance['student_id']] = [
                'status' => $attendance['status'],
                'notes' => $attendance['notes'] ?? null,
            ];
        }
        
        $result = $this->teachingSessionService->saveStudentAttendance($session, $attendanceData);
        
        return response()->json($result);
    }
    
    /**
     * Get teaching session history
     */
    public function history(Request $request)
    {
        $user = $request->user();
        $perPage = $request->input('per_page', 15);
        
        $query = TeachingSession::with(['subject', 'classRoom', 'studentAttendances'])
            ->where('teacher_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc');
            
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }
        
        $sessions = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'sessions' => $sessions,
        ]);
    }
    
    /**
     * Get session details with student attendance
     */
    public function sessionDetail(Request $request, int $sessionId)
    {
        $session = $this->teachingSessionService->getSessionWithAttendance($sessionId);
        
        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Session not found'
            ], 404);
        }
        
        // Check if user owns this session
        if ($session->teacher_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'session' => $session,
        ]);
    }
} 