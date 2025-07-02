<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\TeacherProfile;
use App\Models\User;
use App\Models\Student;
use App\Models\TeachingSession;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Get current date statistics
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');
        
        // Teachers stats
        $totalTeachers = TeacherProfile::count();
        $presentToday = Attendance::whereDate('check_in_time', $today)
            ->whereNotNull('check_in_time')
            ->count();
        
        // Students stats
        $totalStudents = Student::count();
        
        // Attendance stats
        $todayAttendances = Attendance::whereDate('check_in_time', $today)->count();
        $monthlyAttendances = Attendance::where('date', 'like', $thisMonth . '%')->count();
        
        // Teaching sessions stats
        $activeSessions = TeachingSession::whereNull('end_time')
            ->whereDate('start_time', $today)
            ->count();
        
        $todaySessions = TeachingSession::whereDate('start_time', $today)->count();
        
        // Calculate attendance rate
        $attendanceRate = $totalTeachers > 0 ? round(($presentToday / $totalTeachers) * 100, 1) : 0;
        
        return [
            Stat::make('Total Teachers', $totalTeachers)
                ->description('Registered teachers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
                
            Stat::make('Present Today', $presentToday)
                ->description("{$attendanceRate}% attendance rate")
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($attendanceRate >= 80 ? 'success' : ($attendanceRate >= 60 ? 'warning' : 'danger')),
                
            Stat::make('Today Attendances', $todayAttendances)
                ->description('Check-ins today')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),
                
            Stat::make('Active Sessions', $activeSessions)
                ->description('Currently teaching')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),
                
            Stat::make('Today Sessions', $todaySessions)
                ->description('Teaching sessions today')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
                
            Stat::make('Total Students', $totalStudents)
                ->description('Registered students')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),
        ];
    }
    
    protected function getColumns(): int
    {
        return 3;
    }
} 