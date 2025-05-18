<?php

namespace App\Filament\Resources\DeviceRegistrationResource\Pages;

use App\Filament\Resources\DeviceRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeviceRegistration extends EditRecord
{
    protected static string $resource = DeviceRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
