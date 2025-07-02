<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected AttendanceService $attendanceService;
    
    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }
    
    /**
     * Show the unified login form.
     */
    public function loginForm()
    {
        // If already authenticated, redirect based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
    }
    
    /**
     * Handle the unified login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Hubungi administrator.',
                ])->onlyInput('email');
            }
            
            // Special handling for teachers - device validation & attendance integration
            if ($user->role === 'teacher') {
                try {
                    // Handle device registration for teachers
                    $deviceValidation = $this->attendanceService->validateDevice($user, $request);
                    
                    // Create token for API access
                    $token = $user->createToken('teacher-web')->plainTextToken;
                    session(['teacher_token' => $token]);
                    
                } catch (\Exception $e) {
                    // Log the error but don't prevent login
                    \Log::warning('Device validation failed for teacher: ' . $e->getMessage());
                }
            }
            
            // Redirect based on user role
            return $this->redirectBasedOnRole($user);
        }
        
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }
    
    /**
     * Redirect user based on their role.
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect('/admin')->with('success', 'Selamat datang di Admin Panel!');
            case 'teacher':
                return redirect('/teacher/attendance')->with('success', 'Selamat datang, ' . $user->name . '!');
            default:
                Auth::logout();
                return redirect('/')->withErrors(['email' => 'Role tidak dikenali.']);
        }
    }
    
    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        // Delete current access token if exists
        if ($request->user()) {
            $request->user()->currentAccessToken()?->delete();
        }
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
