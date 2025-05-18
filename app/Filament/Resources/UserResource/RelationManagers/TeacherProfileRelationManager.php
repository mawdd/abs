<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'teacherProfile';
    
    protected static ?string $title = 'Teacher Profile';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Textarea::make('bio')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('education')
                    ->maxLength(255),
                Forms\Components\TextInput::make('specialization')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('profile_photo')
                    ->image()
                    ->directory('teacher-photos'),
                Forms\Components\Select::make('subjects')
                    ->relationship('subjects', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('phone_number'),
                Tables\Columns\TextColumn::make('education'),
                Tables\Columns\TextColumn::make('specialization'),
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('subjects.name')
                    ->badge()
                    ->color('success')
                    ->listWithLineBreaks()
                    ->limitList(3),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
