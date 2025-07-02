<?php

namespace App\Filament\Resources\AttendanceLocationResource\Pages;

use App\Filament\Resources\AttendanceLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceLocation extends EditRecord
{
    protected static string $resource = AttendanceLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If this location is set as primary, remove primary status from other locations
        if ($data['is_primary'] ?? false) {
            $this->getModel()::where('id', '!=', $this->record->id)
                ->where('is_primary', true)
                ->update(['is_primary' => false]);
        }
        
        return $data;
    }
} 