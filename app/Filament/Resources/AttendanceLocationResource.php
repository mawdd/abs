<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceLocationResource\Pages;
use App\Models\AttendanceLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceLocationResource extends Resource
{
    protected static ?string $model = AttendanceLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    
    protected static ?string $navigationGroup = 'Pengaturan Sistem';
    
    protected static ?string $navigationLabel = 'Lokasi Absensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric()
                    ->step(0.00000001)
                    ->minValue(-90)
                    ->maxValue(90),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric()
                    ->step(0.00000001)
                    ->minValue(-180)
                    ->maxValue(180),
                Forms\Components\TextInput::make('radius_meters')
                    ->required()
                    ->numeric()
                    ->default(100)
                    ->minValue(1)
                    ->suffix('meters'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Primary Location')
                    ->helperText('Only one location can be primary'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric(decimalPlaces: 6),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric(decimalPlaces: 6),
                Tables\Columns\TextColumn::make('radius_meters')
                    ->numeric()
                    ->suffix(' m'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Primary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_primary'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAttendanceLocations::route('/'),
            'create' => Pages\CreateAttendanceLocation::route('/create'),
            'view' => Pages\ViewAttendanceLocation::route('/{record}'),
            'edit' => Pages\EditAttendanceLocation::route('/{record}/edit'),
        ];
    }
} 