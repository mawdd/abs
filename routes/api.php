<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\TeachingSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Teacher Authentication Routes
Route::prefix('teacher')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
        
        // Daily Attendance Routes
        Route::prefix('attendance')->group(function () {
            Route::get('today', [AttendanceController::class, 'todayStatus']);
            Route::post('check-in', [AttendanceController::class, 'checkIn']);
            Route::post('check-out', [AttendanceController::class, 'checkOut']);
            Route::get('history', [AttendanceController::class, 'history']);
            Route::get('summary', [AttendanceController::class, 'monthlySummary']);
        });
        
        // Teaching Session Routes
        Route::prefix('sessions')->group(function () {
            Route::get('current', [TeachingSessionController::class, 'currentSession']);
            Route::get('options', [TeachingSessionController::class, 'getSessionOptions']);
            Route::post('start', [TeachingSessionController::class, 'startSession']);
            Route::post('{session}/end', [TeachingSessionController::class, 'endSession']);
            Route::get('{session}/students', [TeachingSessionController::class, 'getStudents']);
            Route::post('{session}/attendance', [TeachingSessionController::class, 'saveStudentAttendance']);
            Route::get('history', [TeachingSessionController::class, 'history']);
            Route::get('{session}/detail', [TeachingSessionController::class, 'sessionDetail']);
        });
    });
}); 