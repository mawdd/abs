<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected AttendanceService $attendanceService;
    
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * Show teacher dashboard
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role !== 'teacher' || !$user->is_active) {
            Auth::logout();
            return redirect()->route('teacher.login')->with('error', 'Access denied.');
        }
        
        return view('teacher.dashboard');
    }
    
    /**
     * Handle teacher login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $credentials = $request->only('email', 'password');
        
        if (!Auth::attempt($credentials)) {
            return redirect()->back()
                ->with('error', 'Invalid credentials')
                ->withInput();
        }
        
        $user = Auth::user();
        
        // Check if user is a teacher and active
        if ($user->role !== 'teacher' || !$user->is_active) {
            Auth::logout();
            return redirect()->back()
                ->with('error', 'Access denied. Teachers only.')
                ->withInput();
        }
        
        // Handle device registration for first-time login
        $deviceValidation = $this->attendanceService->validateDevice($user, $request);
        
        // Create token for API access
        $token = $user->createToken('teacher-web')->plainTextToken;
        
        // Store token in session for frontend API calls
        session(['teacher_token' => $token]);
        
        return redirect()->route('teacher.dashboard');
    }
    
    /**
     * Logout teacher
     */
    public function logout(Request $request)
    {
        // Delete current access token
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }
        
        Auth::logout();
        session()->forget('teacher_token');
        
        return redirect()->route('teacher.login')->with('success', 'Logged out successfully');
    }
} 