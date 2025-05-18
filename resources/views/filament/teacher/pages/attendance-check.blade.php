<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
            <h2 class="text-xl font-bold tracking-tight">
                {{ now()->format('l, d F Y') }}
            </h2>
            <div class="text-gray-500 dark:text-gray-400">
                <span id="current-time" class="text-lg font-semibold"></span>
            </div>
        </div>

        <div>
            {{ $this->form }}
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update current time every second
            setInterval(function() {
                const now = new Date();
                const timeStr = now.toLocaleTimeString();
                document.getElementById('current-time').textContent = timeStr;
            }, 1000);
            
            // Get user's geolocation
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const location = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        timestamp: position.timestamp
                    };
                    
                    // Send to Livewire component
                    @this.currentLocation = location;
                    
                    // Display location on the page
                    const locationElement = document.getElementById('current-location');
                    if (locationElement) {
                        locationElement.textContent = `Lat: ${location.latitude.toFixed(6)}, Long: ${location.longitude.toFixed(6)}`;
                    }
                }, function(error) {
                    console.error("Error getting geolocation:", error);
                    const locationElement = document.getElementById('location-status');
                    if (locationElement) {
                        locationElement.textContent = 'Error: Location access denied. Please enable location services.';
                        locationElement.classList.add('text-red-500');
                    }
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
            
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