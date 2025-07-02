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
        // Simplified stats to ensure no errors
        $totalTeachers = TeacherProfile::count();
        $totalStudents = Student::count();
        $totalAttendances = Attendance::count();
        
        return [
            Stat::make('Total Teachers', $totalTeachers)
                ->description('Registered teachers')
                ->color('primary'),
                
            Stat::make('Total Students', $totalStudents)
                ->description('Registered students')
                ->color('success'),
                
            Stat::make('Total Attendances', $totalAttendances)
                ->description('All attendance records')
                ->color('info'),
        ];
    }
    
    protected function getColumns(): int
    {
        return 3;
    }
} 