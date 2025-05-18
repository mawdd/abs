<?php

namespace App\Filament\Resources\DeviceRegistrationResource\Pages;

use App\Filament\Resources\DeviceRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceRegistrations extends ListRecords
{
    protected static string $resource = DeviceRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
