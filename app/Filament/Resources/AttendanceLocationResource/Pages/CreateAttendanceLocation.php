<?php

namespace App\Filament\Resources\AttendanceLocationResource\Pages;

use App\Filament\Resources\AttendanceLocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceLocation extends CreateRecord
{
    protected static string $resource = AttendanceLocationResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If this location is set as primary, remove primary status from other locations
        if ($data['is_primary'] ?? false) {
            $this->getModel()::where('is_primary', true)->update(['is_primary' => false]);
        }
        
        return $data;
    }
} 