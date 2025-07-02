<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeachingSessionResource\Pages;
use App\Models\TeachingSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TeachingSessionResource extends Resource
{
    protected static ?string $model = TeachingSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    
    protected static ?string $navigationGroup = 'Manajemen Pengajaran';
    
    protected static ?string $navigationLabel = 'Sesi Mengajar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                Forms\Components\Select::make('class_room_id')
                    ->relationship('classRoom', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time'),
                Forms\Components\Toggle::make('start_location_valid')
                    ->label('Start Location Valid'),
                Forms\Components\Toggle::make('end_location_valid')
                    ->label('End Location Valid'),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('active'),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classRoom.name')
                    ->label('Class')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->dateTime('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->dateTime('H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->getStateUsing(function ($record) {
                        if ($record->start_time && $record->end_time) {
                            return $record->start_time->diffForHumans($record->end_time, true);
                        }
                        return '-';
                    }),
                Tables\Columns\IconColumn::make('start_location_valid')
                    ->boolean()
                    ->label('Start Valid'),
                Tables\Columns\IconColumn::make('end_location_valid')
                    ->boolean()
                    ->label('End Valid'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'active',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('student_attendances_count')
                    ->counts('studentAttendances')
                    ->label('Students'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('teacher_id')
                    ->label('Teacher')
                    ->relationship('teacher', 'name')
                    ->searchable(),
                Tables\Filters\SelectFilter::make('subject_id')
                    ->label('Subject')
                    ->relationship('subject', 'name'),
                Tables\Filters\SelectFilter::make('class_room_id')
                    ->label('Class')
                    ->relationship('classRoom', 'name'),
                Tables\Filters\SelectFilter::make('status'),
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
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
                Tables\Filters\TernaryFilter::make('location_valid')
                    ->queries(
                        true: fn (Builder $query) => $query->where('start_location_valid', true)->where('end_location_valid', true),
                        false: fn (Builder $query) => $query->where(function ($query) {
                            $query->where('start_location_valid', false)
                                  ->orWhere('end_location_valid', false);
                        }),
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachingSessions::route('/'),
            'create' => Pages\CreateTeachingSession::route('/create'),
            'view' => Pages\ViewTeachingSession::route('/{record}'),
            'edit' => Pages\EditTeachingSession::route('/{record}/edit'),
        ];
    }
} 