<?php

namespace App\Filament\Resources\ClassScheduleResource\Pages;

use App\Filament\Resources\ClassScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClassSchedule extends CreateRecord
{
    protected static string $resource = ClassScheduleResource::class;
    
    protected function getCreateFormActions(): array
    {
        return [
            $this->createFormAction()->label('Buat'),
            $this->createAndCreateAnotherFormAction()->label('Buat & buat lainnya'),
            $this->cancelFormAction()->label('Batal'),
        ];
    }
}
