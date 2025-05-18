<?php

namespace App\Filament\Teacher\Pages;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceHistory extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.teacher.pages.attendance-history';
    
    protected static ?string $navigationLabel = 'Attendance History';
    
    protected static ?string $title = 'My Attendance History';
    
    protected static ?int $navigationSort = 2;
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Attendance::query()
                    ->where('user_id', auth()->id())
                    ->orderBy('date', 'desc')
            )
            ->columns([
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_in_time')
                    ->label('Check In')
                    ->time()
                    ->sortable(),
                TextColumn::make('check_out_time')
                    ->label('Check Out')
                    ->time()
                    ->sortable(),
                IconColumn::make('status')
                    ->label('Status')
                    ->icon(fn (string $state): string => match ($state) {
                        'present' => 'heroicon-o-check-circle',
                        'late' => 'heroicon-o-clock',
                        'absent' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'late' => 'warning',
                        'absent' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('notes')
                    ->limit(30)
                    ->searchable(),
            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),
                SelectFilter::make('status')
                    ->options([
                        'present' => 'Present',
                        'late' => 'Late',
                        'absent' => 'Absent',
                        'pending' => 'Pending',
                    ]),
            ])
            ->defaultSort('date', 'desc');
    }
} 