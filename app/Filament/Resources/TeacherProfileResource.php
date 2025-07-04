<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherProfileResource\Pages;
use App\Filament\Resources\TeacherProfileResource\RelationManagers;
use App\Models\TeacherProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherProfileResource extends Resource
{
    protected static ?string $model = TeacherProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationLabel = 'Profil Guru';
    
    protected static ?string $navigationGroup = 'Manajemen Staf';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name', function ($query) {
                        return $query->where('role', 'teacher');
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Guru'),
                Forms\Components\TextInput::make('qualification')
                    ->maxLength(255)
                    ->label('Kualifikasi'),
                Forms\Components\Textarea::make('bio')
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->label('Biografi'),
                Forms\Components\TextInput::make('specialization')
                    ->maxLength(255)
                    ->label('Spesialisasi'),
                Forms\Components\FileUpload::make('profile_photo')
                    ->image()
                    ->directory('teacher-photos')
                    ->maxSize(5120) // 5MB
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('300')
                    ->imageResizeTargetHeight('300')
                    ->label('Foto Profil'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('user'))
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->user?->name ?? 'Teacher') . '&color=FFFFFF&background=6366F1')
                    ->label('Foto'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable()
                    ->sortable()
                    ->label('Email'),
                Tables\Columns\TextColumn::make('qualification')
                    ->searchable()
                    ->limit(30)
                    ->label('Kualifikasi'),
                Tables\Columns\TextColumn::make('specialization')
                    ->searchable()
                    ->badge()
                    ->label('Spesialisasi'),
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
                Tables\Filters\SelectFilter::make('specialization')
                    ->options(function () {
                        return TeacherProfile::distinct()->pluck('specialization', 'specialization')->toArray();
                    })
                    ->label('Spesialisasi'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
                Tables\Actions\Action::make('view_schedule')
                    ->label('Lihat Jadwal')
                    ->icon('heroicon-o-calendar')
                    ->url(fn (TeacherProfile $record) => route('filament.admin.resources.class-schedules.index', [
                        'tableFilters[teacher][value]' => $record->user_id,
                    ]))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus'),
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
            'index' => Pages\ListTeacherProfiles::route('/'),
            'create' => Pages\CreateTeacherProfile::route('/create'),
            'edit' => Pages\EditTeacherProfile::route('/{record}/edit'),
        ];
    }
}
