<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';
    
    protected static ?string $title = 'Jadwal';
    
    protected static ?string $modelLabel = 'Jadwal Kelas';
    
    protected static ?string $pluralModelLabel = 'Jadwal Kelas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('class_room_id')
                    ->relationship('classRoom', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Ruang Kelas'),
                Forms\Components\Select::make('teacher_id')
                    ->relationship('teacher', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Guru'),
                Forms\Components\Select::make('day_of_week')
                    ->options([
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu',
                    ])
                    ->required()
                    ->label('Hari'),
                Forms\Components\TimePicker::make('start_time')
                    ->seconds(false)
                    ->required()
                    ->label('Waktu Mulai'),
                Forms\Components\TimePicker::make('end_time')
                    ->seconds(false)
                    ->required()
                    ->after('start_time')
                    ->label('Waktu Selesai'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required()
                    ->label('Aktif'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('classRoom.name')
                    ->searchable()
                    ->sortable()
                    ->label('Ruang Kelas'),
                Tables\Columns\TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable()
                    ->label('Guru'),
                Tables\Columns\TextColumn::make('day_name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Monday', 'Wednesday', 'Friday' => 'primary',
                        'Tuesday', 'Thursday' => 'success',
                        'Saturday', 'Sunday' => 'warning',
                        default => 'gray',
                    })
                    ->label('Hari'),
                Tables\Columns\TextColumn::make('time_range')
                    ->label('Waktu'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Aktif'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Buat Jadwal'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                ]),
            ]);
    }
}
