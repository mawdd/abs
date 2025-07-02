<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Models\AttendanceLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Test route untuk debug
Route::get('/test', function () {
    return 'Laravel works! Time: ' . now();
});

// Info route untuk IP addresses
Route::get('/info', function () {
    $serverIP = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
    $serverName = $_SERVER['SERVER_NAME'] ?? 'Unknown';
    $httpHost = $_SERVER['HTTP_HOST'] ?? 'Unknown';
    
    return response()->json([
        'server_ip' => $serverIP,
        'server_name' => $serverName,
        'http_host' => $httpHost,
        'suggested_mobile_url' => 'http://' . request()->getHost() . ':8000',
        'current_url' => request()->url(),
    ]);
});

// Location debug routes
Route::get('/location-debug', function () {
    $primaryLocation = AttendanceLocation::where('is_primary', true)->first();
    
    return response()->json([
        'primary_location' => $primaryLocation,
        'all_locations' => AttendanceLocation::all(),
        'current_time' => now()->format('Y-m-d H:i:s'),
    ]);
});

Route::post('/update-school-location', function (Request $request) {
    $latitude = $request->input('latitude');
    $longitude = $request->input('longitude');
    $radius = $request->input('radius', 200);
    
    if (!$latitude || !$longitude) {
        return response()->json(['error' => 'Latitude and longitude required']);
    }
    
    $location = AttendanceLocation::where('is_primary', true)->first();
    
    if ($location) {
        $location->update([
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius_meters' => $radius,
        ]);
    } else {
        AttendanceLocation::create([
            'name' => 'Main School Building',
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius_meters' => $radius,
            'is_active' => true,
            'is_primary' => true,
            'description' => 'Primary attendance location for the school',
        ]);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'School location updated successfully',
        'location' => AttendanceLocation::where('is_primary', true)->first(),
    ]);
});

// Quick route to increase radius for testing
Route::get('/increase-radius/{meters?}', function ($meters = 500) {
    $location = AttendanceLocation::where('is_primary', true)->first();
    
    if ($location) {
        $location->update(['radius_meters' => $meters]);
        return response()->json([
            'success' => true,
            'message' => "Radius updated to {$meters} meters for testing",
            'location' => $location
        ]);
    }
    
    return response()->json(['error' => 'No primary location found']);
});

// Quick route to set school coordinates easily
Route::get('/set-school-location/{lat}/{lng}/{radius?}', function ($lat, $lng, $radius = 100) {
    $location = AttendanceLocation::where('is_primary', true)->first();
    
    if ($location) {
        $location->update([
            'latitude' => $lat,
            'longitude' => $lng,
            'radius_meters' => $radius,
        ]);
    } else {
        AttendanceLocation::create([
            'name' => 'Main School Building',
            'latitude' => $lat,
            'longitude' => $lng,
            'radius_meters' => $radius,
            'is_active' => true,
            'is_primary' => true,
            'description' => 'Primary attendance location for the school',
        ]);
    }
    
    return response()->json([
        'success' => true,
        'message' => "School location updated to coordinates: {$lat}, {$lng} with {$radius}m radius",
        'location' => AttendanceLocation::where('is_primary', true)->first(),
    ]);
});

// PWA Offline support
Route::get('/offline', function () {
    return view('offline');
});

// Unified Login System - Satu halaman login untuk semua user
Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect all login attempts to main login page
Route::get('/admin/login', function () {
    return redirect()->route('login')->with('info', 'Silakan gunakan halaman login utama.');
});

Route::get('/teacher/login', function () {
    return redirect()->route('login')->with('info', 'Silakan gunakan halaman login utama.');
});

// Teacher dashboard routes - untuk setelah login
Route::prefix('teacher')->name('teacher.')->middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    
    // Attendance routes
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
