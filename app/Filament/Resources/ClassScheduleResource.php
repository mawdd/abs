<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassScheduleResource\Pages;
use App\Filament\Resources\ClassScheduleResource\RelationManagers;
use App\Models\ClassSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

class ClassScheduleResource extends Resource
{
    protected static ?string $model = ClassSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $navigationLabel = 'Jadwal Kelas';
    
    protected static ?string $navigationGroup = 'Manajemen Akademik';
    
    protected static ?string $modelLabel = 'Jadwal Kelas';
    
    protected static ?string $pluralModelLabel = 'Jadwal Kelas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Mata Pelajaran')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama'),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->label('Deskripsi'),
                    ]),
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
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('subject.name')
                    ->searchable()
                    ->sortable()
                    ->label('Mata Pelajaran'),
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
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('day_of_week', $direction))
                    ->label('Hari'),
                Tables\Columns\TextColumn::make('time_range')
                    ->label('Waktu')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query
                        ->where('start_time', 'like', "%{$search}%")
                        ->orWhere('end_time', 'like', "%{$search}%"))
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('start_time', $direction)),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat Pada'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diperbarui Pada'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject')
                    ->relationship('subject', 'name')
                    ->label('Mata Pelajaran'),
                Tables\Filters\SelectFilter::make('class_room')
                    ->relationship('classRoom', 'name')
                    ->label('Ruang Kelas'),
                Tables\Filters\SelectFilter::make('teacher')
                    ->relationship('teacher', 'name')
                    ->label('Guru'),
                Tables\Filters\SelectFilter::make('day_of_week')
                    ->options([
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu',
                    ])
                    ->label('Hari'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua Jadwal')
                    ->trueLabel('Jadwal Aktif')
                    ->falseLabel('Jadwal Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation(),
                ]),
            ]);
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
            'index' => Pages\ListClassSchedules::route('/'),
            'create' => Pages\CreateClassSchedule::route('/create'),
            'edit' => Pages\EditClassSchedule::route('/{record}/edit'),
        ];
    }
}
