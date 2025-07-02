<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestAttendance extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                    ->with(['user.teacherProfile'])
                    ->latest('check_in_time')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Teacher Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('check_in_time')
                    ->label('Check In')
                    ->time('H:i')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('check_out_time')
                    ->label('Check Out')
                    ->time('H:i')
                    ->placeholder('Not yet')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('check_in_location_valid')
                    ->label('Location Valid')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                Tables\Columns\TextColumn::make('working_hours')
                    ->label('Working Hours')
                    ->getStateUsing(function (Attendance $record) {
                        if ($record->check_in_time && $record->check_out_time) {
                            $checkIn = \Carbon\Carbon::parse($record->check_in_time);
                            $checkOut = \Carbon\Carbon::parse($record->check_out_time);
                            $diff = $checkOut->diff($checkIn);
                            return $diff->format('%h hours %i minutes');
                        }
                        return $record->check_in_time ? 'Still working' : '-';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Still working' => 'warning',
                        default => 'success',
                    }),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function (Attendance $record) {
                        if (!$record->check_in_time) {
                            return 'Absent';
                        }
                        if (!$record->check_out_time) {
                            return 'Present';
                        }
                        return 'Complete';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Absent' => 'danger',
                        'Present' => 'warning',
                        'Complete' => 'success',
                    }),
            ])
            ->defaultSort('check_in_time', 'desc')
            ->heading('Latest Attendance Records')
            ->description('Recent teacher attendance activities')
            ->emptyStateHeading('No attendance records')
            ->emptyStateDescription('Attendance records will appear here once teachers start checking in.')
            ->emptyStateIcon('heroicon-o-clock')
            ->poll('30s'); // Auto refresh every 30 seconds
    }
}
