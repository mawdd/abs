<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
            <h2 class="text-xl font-bold tracking-tight">
                My Registered Devices
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                Manage devices you use for attendance
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
                    <h3 class="text-lg font-semibold mb-4">Device List</h3>
                    {{ $this->table }}
                </div>
            </div>
            
            <div class="md:col-span-1">
                <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
                    <h3 class="text-lg font-semibold mb-4">Register Current Device</h3>
                    {{ $this->form }}
                    
                    <button type="button" class="mt-4 w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded" wire:click="registerCurrentDevice">
                        Register This Device
                    </button>
                    
                    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                        <p>You can only use registered devices for attendance.</p>
                        <p>Device registration may require approval from admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get device/browser fingerprint
            const deviceInfo = {
                userAgent: navigator.userAgent,
                platform: navigator.platform,
                screenWidth: window.screen.width,
                screenHeight: window.screen.height,
                language: navigator.language,
                vendor: navigator.vendor,
                timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
            };
            
            // Send to Livewire component
            @this.deviceInfo = JSON.stringify(deviceInfo);
        });
    </script>
</x-filament-panels::page> 