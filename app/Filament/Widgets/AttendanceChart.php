<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\TeacherProfile;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class AttendanceChart extends ChartWidget
{
    protected static ?string $heading = 'Weekly Attendance Overview';
    
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        // Get data for the last 7 days
        $endDate = now();
        $startDate = now()->subDays(6);
        
        $totalTeachers = TeacherProfile::count();
        
        $attendanceData = [];
        $labels = [];
        $presentData = [];
        $absentData = [];
        
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dayAttendances = Attendance::whereDate('check_in_time', $date->format('Y-m-d'))
                ->whereNotNull('check_in_time')
                ->count();
            
            $labels[] = $date->format('M d');
            $presentData[] = $dayAttendances;
            $absentData[] = max(0, $totalTeachers - $dayAttendances);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Present',
                    'data' => $presentData,
                    'backgroundColor' => '#10B981',
                    'borderColor' => '#059669',
                    'borderWidth' => 2,
                    'fill' => false,
                ],
                [
                    'label' => 'Absent',
                    'data' => $absentData,
                    'backgroundColor' => '#EF4444',
                    'borderColor' => '#DC2626',
                    'borderWidth' => 2,
                    'fill' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'elements' => [
                'point' => [
                    'radius' => 4,
                    'hoverRadius' => 6,
                ],
            ],
        ];
    }
} 