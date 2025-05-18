<?php

namespace App\Filament\Teacher\Pages;

use App\Models\DeviceRegistration;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DeviceManagement extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static string $view = 'filament.teacher.pages.device-management';
    
    protected static ?string $navigationLabel = 'My Devices';
    
    protected static ?string $title = 'Device Management';
    
    protected static ?int $navigationSort = 3;
    
    public $deviceInfo = null;
    public $notes = '';
    
    public function mount(): void
    {
        $this->form->fill([
            'notes' => '',
        ]);
    }
    
    public function registerCurrentDevice()
    {
        // In a real implementation, we would handle device fingerprinting properly
        if (!$this->deviceInfo) {
            Notification::make()
                ->title('Unable to get device information')
                ->danger()
                ->send();
            return;
        }
        
        $deviceIdentifier = json_decode($this->deviceInfo, true);
        $deviceIdentifier = md5(json_encode($deviceIdentifier));
        
        // Check if this device is already registered
        $existingDevice = DeviceRegistration::where('device_identifier', $deviceIdentifier)
            ->first();
            
        if ($existingDevice) {
            Notification::make()
                ->title('This device is already registered')
                ->warning()
                ->send();
            return;
        }
        
        // Create a new device registration
        DeviceRegistration::create([
            'user_id' => Auth::id(),
            'device_identifier' => $deviceIdentifier,
            'device_details' => $this->deviceInfo,
            'notes' => $this->notes,
            'is_active' => true,
            'last_used_at' => now(),
        ]);
        
        Notification::make()
            ->title('Device registered successfully')
            ->success()
            ->send();
            
        $this->form->fill([
            'notes' => '',
        ]);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                DeviceRegistration::query()
                    ->where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date Registered')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('last_used_at')
                    ->label('Last Used')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('notes')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('approved_at')
                    ->label('Approved On')
                    ->dateTime(),
            ]);
    }
    
    public function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Section::make('Register New Device')
                    ->description('Register your current device to use for attendance')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Device Notes (optional)')
                            ->placeholder('e.g. My work phone')
                            ->maxLength(255),
                    ])
                    ->aside(),
            ]);
    }
} 