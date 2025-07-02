<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventLogoutDuringAttendance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's an active attendance process
        $activeProcess = session('attendance_in_progress');
        
        if ($activeProcess && $request->is('logout') && !$request->has('force_logout')) {
            return response()->json([
                'success' => false,
                'message' => 'Proses absensi sedang berlangsung. Yakin ingin logout?',
                'confirm_logout' => true,
                'logout_url' => route('logout') . '?force_logout=1'
            ]);
        }
        
        return $next($request);
    }
} 