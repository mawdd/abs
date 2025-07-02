<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi Guru - {{ config('app.name') }}</title>
    
    <!-- PWA Meta Tags -->
    <meta name="application-name" content="Sistem Absensi Guru">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Absensi Guru">
    <meta name="description" content="Aplikasi absensi guru dengan validasi GPS">
    <meta name="format-detection" content="telephone=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#3b82f6">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        /* PWA specific styles */
        @media (display-mode: standalone) {
            body {
                -webkit-user-select: none;
                -webkit-touch-callout: none;
            }
        }
        
        /* Install prompt styles */
        .install-prompt {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(45deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
        }
        
        .install-prompt.show {
            transform: translateY(0);
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-md">
        <!-- PWA Installation Banner -->
        <div id="pwa-install-banner" class="hidden bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-4 mb-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-mobile-alt text-2xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-sm">Install Aplikasi</h4>
                        <p class="text-xs opacity-90">Akses lebih cepat & notifikasi</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button onclick="installPWA()" class="bg-white text-blue-600 px-3 py-1 rounded text-sm font-medium">
                        Install
                    </button>
                    <button onclick="document.getElementById('pwa-install-banner').style.display='none'" class="text-white opacity-75">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="text-center">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle text-2xl text-gray-400 mr-2"></i>
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 flex items-center transition-colors">
                            <i class="fas fa-sign-out-alt mr-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Absensi Guru</h1>
                <p class="text-sm text-gray-500" id="current-date">{{ now()->format('l, d F Y') }}</p>
                <p class="text-lg font-semibold text-blue-600" id="current-time">{{ now()->format('H:i:s') }}</p>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Status Hari Ini</h2>
            
            @if($todayAttendance)
                <div class="space-y-3">
                    @if($todayAttendance->check_in_time)
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-sign-in-alt text-green-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-green-800">Check In</p>
                                    <p class="text-sm text-green-600">{{ $todayAttendance->check_in_time->format('H:i:s') }}</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    @endif

                    @if($todayAttendance->check_out_time)
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-sign-out-alt text-blue-600 mr-3"></i>
                                <div>
                                    <p class="font-medium text-blue-800">Check Out</p>
                                    <p class="text-sm text-blue-600">{{ $todayAttendance->check_out_time->format('H:i:s') }}</p>
                                </div>
                            </div>
                            <i class="fas fa-check-circle text-blue-600"></i>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clock text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">Belum absen hari ini</p>
                </div>
            @endif
        </div>

        <!-- Location Status -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Status Lokasi</h2>
                @if(auth()->user()->role === 'admin')
                <button 
                    id="update-school-location-btn"
                    class="text-sm bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded"
                    title="Set lokasi sekolah berdasarkan posisi saat ini"
                >
                    <i class="fas fa-map-pin mr-1"></i>
                    Set Lokasi Sekolah
                </button>
                @endif
            </div>
            <div id="location-status">
                <div class="text-center py-4">
                    <i class="fas fa-map-marker-alt text-gray-400 text-2xl mb-2"></i>
                    <p class="text-gray-500">Mengambil lokasi...</p>
                </div>
            </div>
            
            <!-- Manual GPS Request Button -->
            <div id="gps-request-section" class="hidden mt-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 mb-1">Akses Lokasi Diperlukan</h4>
                            <p class="text-sm text-blue-700">
                                Untuk melakukan absensi, aplikasi memerlukan akses ke lokasi Anda untuk memastikan Anda berada di area sekolah.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <button 
                            id="request-gps-btn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium"
                        >
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Coba GPS
                        </button>
                        <button 
                            onclick="tryNetworkLocation()"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium"
                        >
                            <i class="fas fa-wifi mr-2"></i>
                            Via WiFi
                        </button>
                    </div>
                    
                    <div class="text-xs text-gray-500 space-y-1">
                        <div>💡 <strong>Tips:</strong></div>
                        <div>• Pastikan lokasi aktif di device</div>
                        <div>• Izinkan akses lokasi saat diminta browser</div>
                        <div>• Jika GPS lambat, coba tombol "Via WiFi"</div>
                        <div>• Refresh halaman jika masih bermasalah</div>
                    </div>
                    
                    <details class="mt-4">
                        <summary class="text-sm text-gray-700 cursor-pointer hover:text-blue-600">
                            <i class="fas fa-keyboard mr-1"></i>
                            Input Manual Koordinat (Jika GPS Tidak Berfungsi)
                        </summary>
                        <div class="mt-3 p-3 bg-gray-50 rounded border space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <input 
                                    type="number" 
                                    id="manual-lat" 
                                    placeholder="Latitude" 
                                    step="any"
                                    class="px-2 py-1 border rounded text-sm"
                                >
                                <input 
                                    type="number" 
                                    id="manual-lng" 
                                    placeholder="Longitude" 
                                    step="any"
                                    class="px-2 py-1 border rounded text-sm"
                                >
                            </div>
                            <button 
                                id="manual-location-btn"
                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded text-sm w-full"
                            >
                                <i class="fas fa-map-pin mr-1"></i>
                                Gunakan Koordinat Manual
                            </button>
                            <button 
                                onclick="getCurrentLocationFromMaps()"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm w-full"
                            >
                                <i class="fas fa-map mr-1"></i>
                                Ambil dari Google Maps
                            </button>
                            <button 
                                onclick="window.location.reload()"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm w-full"
                            >
                                <i class="fas fa-sync-alt mr-1"></i>
                                Refresh Halaman
                            </button>
                            <div class="text-xs text-gray-600 space-y-1">
                                <div>💡 Cara mendapatkan koordinat:</div>
                                <div>1. Buka Google Maps</div>
                                <div>2. Klik kanan di lokasi Anda</div>
                                <div>3. Pilih koordinat yang muncul</div>
                                <div>4. Copy dan paste di atas</div>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
            <textarea 
                id="notes" 
                rows="3" 
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Tambahkan catatan untuk absensi hari ini..."
            ></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-4">
            @if(!$todayAttendance || !$todayAttendance->check_in_time)
                <button 
                    id="check-in-btn"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Check In
                </button>
            @elseif(!$todayAttendance->check_out_time)
                <button 
                    id="check-out-btn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transform transition hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled
                >
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Check Out
                </button>
            @else
                <div class="w-full bg-gray-200 text-gray-600 font-bold py-4 px-6 rounded-lg text-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Absensi Hari Ini Sudah Lengkap
                </div>
            @endif
        </div>

        <!-- Quick Links -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <a href="{{ route('teacher.attendance.history') }}" class="bg-white p-4 rounded-lg shadow-md text-center hover:shadow-lg transition">
                <i class="fas fa-history text-gray-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Riwayat</p>
            </a>
            <a href="{{ route('teacher.dashboard') }}" class="bg-white p-4 rounded-lg shadow-md text-center hover:shadow-lg transition">
                <i class="fas fa-tachometer-alt text-gray-600 text-xl mb-2"></i>
                <p class="text-sm font-medium text-gray-800">Dashboard</p>
            </a>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loading-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl">
            <div class="text-center">
                <i class="fas fa-spinner fa-spin text-blue-600 text-3xl mb-4"></i>
                <p class="text-gray-700">Memproses absensi...</p>
            </div>
        </div>
    </div>

    <script>
        let currentLocation = null;
        let primaryLocation = @json($primaryLocation);

        // Update time every second
        setInterval(function() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString();
        }, 1000);

        // Auto-request GPS permission on page load with delay
        window.addEventListener('load', function() {
            // Small delay to ensure page is fully loaded
            setTimeout(() => {
                requestLocation();
            }, 1000);
        });
        
        // Add visibility change handler to retry GPS when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && !currentLocation) {
                console.log('Page became visible, retrying GPS...');
                setTimeout(() => {
                    requestLocation();
                }, 500);
            }
        });

        // Function to request location
        function requestLocation() {
            if (!navigator.geolocation) {
                updateLocationStatus(false, 'Geolocation tidak didukung browser');
                return;
            }

            // Show loading state
            updateLocationStatus(null, 'Meminta akses lokasi...');
            
            // Add timeout indicator with auto-fallback
            let timeoutCounter = 0;
            let hasLocationFound = false;
            const timeoutIndicator = setInterval(() => {
                timeoutCounter += 1;
                if (timeoutCounter <= 8) {
                    updateLocationStatus(null, `Mencari sinyal GPS... (${timeoutCounter}s)`);
                } else if (timeoutCounter <= 15) {
                    updateLocationStatus(null, `Coba mode cepat... (${timeoutCounter}s)`);
                } else {
                    clearInterval(timeoutIndicator);
                    if (!hasLocationFound) {
                        // Auto-fallback to network location after 15 seconds
                        tryNetworkLocation();
                    }
                }
            }, 1000);
            
            // Enhanced GPS options with multiple fallbacks
            const quickOptions = {
                enableHighAccuracy: false,
                timeout: 3000,
                maximumAge: 60000  // 1 minute cache for quick response
            };
            
            const preciseOptions = {
                enableHighAccuracy: true,
                timeout: 8000,
                maximumAge: 30000  // 30 seconds cache
            };
            
            const networkOptions = {
                enableHighAccuracy: false,
                timeout: 5000,
                maximumAge: 10000  // 10 seconds cache for network-based location
            };
            
            // Function to handle successful location
            function handleLocationSuccess(position, method = 'GPS') {
                hasLocationFound = true;
                clearInterval(timeoutIndicator);
                
                currentLocation = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    accuracy: position.coords.accuracy,
                    method: method
                };
                
                console.log(`Location Success (${method}):`, currentLocation);
                updateLocationStatus(true, `Lokasi ditemukan via ${method} (akurasi: ${Math.round(position.coords.accuracy)}m)`);
                enableButtons();
                hideGpsRequestSection();
            }
            
            // Function to handle location errors
            function handleLocationError(error, method = 'GPS') {
                console.log(`${method} failed:`, error);
                
                let errorMessage = `${method} gagal`;
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Akses lokasi ditolak. Aktifkan lokasi di browser.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'GPS tidak tersedia. Coba di area terbuka atau gunakan WiFi.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = `${method} timeout. Mencoba metode lain...`;
                        break;
                }
                
                console.warn(errorMessage);
                return errorMessage;
            }
            
            // Try quick network-based location first
            navigator.geolocation.getCurrentPosition(
                (position) => handleLocationSuccess(position, 'Network'),
                (error) => {
                    handleLocationError(error, 'Network');
                    
                    // If network fails, try precise GPS
                    navigator.geolocation.getCurrentPosition(
                        (position) => handleLocationSuccess(position, 'GPS Precisi'),
                        (error) => {
                            handleLocationError(error, 'GPS Precisi');
                            
                            // Final fallback to any available location
                            navigator.geolocation.getCurrentPosition(
                                (position) => handleLocationSuccess(position, 'GPS Fallback'),
                                (error) => {
                                    hasLocationFound = true;
                                    clearInterval(timeoutIndicator);
                                    
                                    const finalError = handleLocationError(error, 'GPS Final');
                                    updateLocationStatus(false, finalError);
                                    showGpsRequestSection();
                                    
                                    // Show manual input as last resort
                                    setTimeout(() => {
                                        if (!currentLocation) {
                                            showManualLocationOption();
                                        }
                                    }, 2000);
                                },
                                quickOptions
                            );
                        },
                        preciseOptions
                    );
                },
                networkOptions
            );
        }
        
        // Try network-based location (faster)
        function tryNetworkLocation() {
            updateLocationStatus(null, 'Mencoba lokasi jaringan...');
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    currentLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy,
                        method: 'Network'
                    };
                    
                    console.log('Network Location Success:', currentLocation);
                    updateLocationStatus(true, `Lokasi jaringan ditemukan (akurasi: ${Math.round(position.coords.accuracy)}m)`);
                    enableButtons();
                    hideGpsRequestSection();
                },
                function(error) {
                    console.error('Network location failed:', error);
                    updateLocationStatus(false, 'Semua metode lokasi gagal. Gunakan input manual.');
                    showGpsRequestSection();
                    showManualLocationOption();
                },
                {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 10000
                }
            );
        }
        
        // Show manual location input prominently
        function showManualLocationOption() {
            const manualSection = document.getElementById('gps-request-section');
            if (manualSection) {
                manualSection.classList.remove('hidden');
                
                // Auto-expand manual input
                const manualDetails = manualSection.querySelector('details');
                if (manualDetails) {
                    manualDetails.open = true;
                    
                    // Add prominent notice
                    const notice = document.createElement('div');
                    notice.className = 'bg-yellow-100 border border-yellow-400 text-yellow-800 p-3 rounded mb-3';
                    notice.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <div>
                                <strong>GPS Bermasalah?</strong>
                                <p class="text-sm">Gunakan input manual di bawah atau coba refresh halaman.</p>
                            </div>
                        </div>
                    `;
                    
                    manualDetails.insertBefore(notice, manualDetails.firstChild);
                }
            }
        }

        // Manual GPS request button
        document.addEventListener('click', function(e) {
            if (e.target.id === 'request-gps-btn' || e.target.closest('#request-gps-btn')) {
                requestLocation();
            }
            
            // Update school location button (admin only)
            if (e.target.id === 'update-school-location-btn' || e.target.closest('#update-school-location-btn')) {
                updateSchoolLocation();
            }
            
            // Manual location input
            if (e.target.id === 'manual-location-btn') {
                setManualLocation();
            }
        });

        function updateSchoolLocation() {
            if (!currentLocation) {
                alert('Lokasi GPS belum tersedia. Pastikan GPS aktif terlebih dahulu.');
                return;
            }
            
            if (!confirm('Apakah Anda yakin ingin mengubah lokasi sekolah berdasarkan posisi Anda saat ini?\n\nLokasi: ' + 
                       currentLocation.latitude.toFixed(6) + ', ' + currentLocation.longitude.toFixed(6))) {
                return;
            }
            
            fetch('/update-school-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: currentLocation.latitude,
                    longitude: currentLocation.longitude,
                    radius: 100
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Lokasi sekolah berhasil diupdate!\n\n' +
                          'Latitude: ' + data.location.latitude + '\n' +
                          'Longitude: ' + data.location.longitude + '\n' +
                          'Radius: ' + data.location.radius_meters + ' meter');
                    
                    // Update primaryLocation variable
                    primaryLocation = data.location;
                    
                    // Refresh location status
                    updateLocationStatus(true);
                    enableButtons();
                } else {
                    alert('Gagal mengupdate lokasi sekolah: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengupdate lokasi sekolah.');
            });
        }

        function updateLocationStatus(success, errorMessage = null) {
            const statusDiv = document.getElementById('location-status');
            
            if (success === null) {
                // Loading state
                statusDiv.innerHTML = `
                    <div class="flex items-center text-blue-600">
                        <i class="fas fa-spinner fa-spin mr-3"></i>
                        <div>
                            <p class="font-medium">Mengambil Lokasi...</p>
                            <p class="text-sm opacity-75">${errorMessage || 'Mohon tunggu'}</p>
                        </div>
                    </div>
                `;
            } else if (success && currentLocation) {
                const distance = primaryLocation ? calculateDistance(
                    currentLocation.latitude, 
                    currentLocation.longitude,
                    primaryLocation.latitude, 
                    primaryLocation.longitude
                ) : 0;
                
                const isValid = primaryLocation ? distance <= primaryLocation.radius_meters : true;
                
                statusDiv.innerHTML = `
                    <div class="flex items-center ${isValid ? 'text-green-600' : 'text-red-600'}">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        <div>
                            <p class="font-medium">${isValid ? 'Lokasi Valid' : 'Di Luar Area'}</p>
                            <p class="text-sm opacity-75">
                                Your: ${currentLocation.latitude.toFixed(6)}, ${currentLocation.longitude.toFixed(6)}
                            </p>
                            ${primaryLocation ? `
                                <p class="text-xs opacity-75">School: ${primaryLocation.latitude.toFixed(6)}, ${primaryLocation.longitude.toFixed(6)}</p>
                                <p class="text-xs opacity-75">Jarak: ${distance.toFixed(0)}m (Max: ${primaryLocation.radius_meters}m)</p>
                            ` : '<p class="text-xs text-yellow-600">⚠️ Lokasi sekolah belum diset</p>'}
                        </div>
                    </div>
                `;
            } else {
                statusDiv.innerHTML = `
                    <div class="flex items-center text-red-600">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        <div>
                            <p class="font-medium">Lokasi Tidak Tersedia</p>
                            <p class="text-sm opacity-75">${errorMessage || 'Gagal mengambil lokasi'}</p>
                        </div>
                    </div>
                `;
            }
        }

        function showGpsRequestSection() {
            document.getElementById('gps-request-section').classList.remove('hidden');
        }

        function hideGpsRequestSection() {
            document.getElementById('gps-request-section').classList.add('hidden');
        }

        function setManualLocation() {
            const lat = parseFloat(document.getElementById('manual-lat').value);
            const lng = parseFloat(document.getElementById('manual-lng').value);
            
            if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                alert('Mohon masukkan koordinat latitude dan longitude yang valid');
                return;
            }
            
            if (lat < -90 || lat > 90) {
                alert('Latitude harus antara -90 dan 90');
                return;
            }
            
            if (lng < -180 || lng > 180) {
                alert('Longitude harus antara -180 dan 180');
                return;
            }
            
            currentLocation = {
                latitude: lat,
                longitude: lng,
                accuracy: 999  // Manual input has low accuracy
            };
            
            console.log('Manual Location Set:', currentLocation);
            updateLocationStatus(true, 'Lokasi manual digunakan');
            enableButtons();
                        hideGpsRequestSection();
        }
        
        // Helper function to get location from Google Maps (instructions)
        function getCurrentLocationFromMaps() {
            const instructionsModal = document.createElement('div');
            instructionsModal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            instructionsModal.innerHTML = `
                <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-bold mb-4">📍 Ambil Koordinat dari Google Maps</h3>
                    <div class="text-sm text-gray-700 space-y-3 mb-6">
                        <div><strong>Langkah 1:</strong> Buka Google Maps di tab baru</div>
                        <div><strong>Langkah 2:</strong> Tekan dan tahan lokasi Anda di peta</div>
                        <div><strong>Langkah 3:</strong> Koordinat akan muncul di bawah</div>
                        <div><strong>Langkah 4:</strong> Copy koordinat tersebut</div>
                        <div><strong>Langkah 5:</strong> Paste di form input manual</div>
                    </div>
                    <div class="space-y-2">
                        <button onclick="window.open('https://maps.google.com', '_blank')" class="w-full bg-blue-600 text-white py-2 rounded-lg">
                            Buka Google Maps
                        </button>
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="w-full bg-gray-600 text-white py-2 rounded-lg">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
            document.body.appendChild(instructionsModal);
        }
        
        function enableButtons() {
            const checkInBtn = document.getElementById('check-in-btn');
            const checkOutBtn = document.getElementById('check-out-btn');
            
            // Only enable if location is valid
            const isLocationValid = validateCurrentLocation();
            
            if (checkInBtn) {
                checkInBtn.disabled = !isLocationValid;
                if (!isLocationValid) {
                    checkInBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    checkInBtn.title = 'Anda berada di luar area sekolah';
                } else {
                    checkInBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    checkInBtn.title = '';
                }
            }
            
            if (checkOutBtn) {
                checkOutBtn.disabled = !isLocationValid;
                if (!isLocationValid) {
                    checkOutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    checkOutBtn.title = 'Anda berada di luar area sekolah';
                } else {
                    checkOutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    checkOutBtn.title = '';
                }
            }
        }

        function validateCurrentLocation() {
            if (!currentLocation || !primaryLocation) {
                return false;
            }
            
            const distance = calculateDistance(
                currentLocation.latitude,
                currentLocation.longitude,
                primaryLocation.latitude,
                primaryLocation.longitude
            );
            
            return distance <= primaryLocation.radius_meters;
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371000; // Earth's radius in meters
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Handle check-in
        document.addEventListener('click', function(e) {
            if (e.target.id === 'check-in-btn') {
                if (!currentLocation) {
                    alert('Lokasi belum tersedia. Pastikan GPS aktif dan izinkan akses lokasi.');
                    return;
                }
                
                performAttendance('check-in');
            }
            
            if (e.target.id === 'check-out-btn') {
                if (!currentLocation) {
                    alert('Lokasi belum tersedia. Pastikan GPS aktif dan izinkan akses lokasi.');
                    return;
                }
                
                performAttendance('check-out');
            }
        });

        function performAttendance(type) {
            // Set attendance in progress
            sessionStorage.setItem('attendance_in_progress', 'true');
            
            // Double check location validation
            if (!validateCurrentLocation()) {
                sessionStorage.removeItem('attendance_in_progress');
                alert('Anda berada di luar area sekolah. Absensi tidak dapat dilakukan.');
                return;
            }
            
            const modal = document.getElementById('loading-modal');
            modal.classList.remove('hidden');
            
            const url = type === 'check-in' ? '{{ route("teacher.attendance.checkin") }}' : '{{ route("teacher.attendance.checkout") }}';
            const notes = document.getElementById('notes').value;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: currentLocation.latitude,
                    longitude: currentLocation.longitude,
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                modal.classList.add('hidden');
                sessionStorage.removeItem('attendance_in_progress');
                
                // Debug log
                console.log('Backend Response:', data);
                if (data.debug) {
                    console.log('Debug Info:', data.debug);
                    console.log('Frontend calculated distance:', primaryLocation ? calculateDistance(
                        currentLocation.latitude,
                        currentLocation.longitude,
                        primaryLocation.latitude,
                        primaryLocation.longitude
                    ) : 'No school location');
                }
                
                // Handle session expiry
                if (data.redirect && data.redirect_url) {
                    alert(data.message + ' Mengarahkan ke halaman login...');
                    window.location.href = data.redirect_url;
                    return;
                }
                
                if (data.success) {
                    // Show success with auto-reload
                    showSuccessMessage(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    // Check if admin can override location validation
                    if (data.allow_override && data.location_validation && !data.location_validation.valid) {
                        const override = confirm(
                            data.message + '\n\n' +
                            'Sebagai admin, Anda dapat melanjutkan absensi di luar area. ' +
                            'Lanjutkan?'
                        );
                        
                        if (override) {
                            performAttendanceOverride(type);
                            return;
                        }
                    }
                    
                    showErrorMessage(data.message);
                }
            })
            .catch(error => {
                modal.classList.add('hidden');
                sessionStorage.removeItem('attendance_in_progress');
                console.error('Error:', error);
                
                // Handle network errors
                if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    showErrorMessage('Koneksi internet bermasalah. Periksa koneksi Anda dan coba lagi.');
                } else {
                    showErrorMessage('Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
                }
            });
        }
        
        // Enhanced message display functions
        function showSuccessMessage(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 left-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg z-50 flex items-center';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <div>
                    <p class="font-medium">${message}</p>
                    <p class="text-sm opacity-90">Halaman akan refresh otomatis...</p>
                </div>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 4000);
        }
        
        function showErrorMessage(message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 left-4 right-4 bg-red-600 text-white p-4 rounded-lg shadow-lg z-50 flex items-center';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle text-xl mr-3"></i>
                <div>
                    <p class="font-medium">Error</p>
                    <p class="text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="ml-auto text-white opacity-75 hover:opacity-100">
                    <i class="fas fa-times"></i>
                </button>
            `;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 8000);
        }
        
        // Admin override function
        function performAttendanceOverride(type) {
            const modal = document.getElementById('loading-modal');
            modal.classList.remove('hidden');
            
            const url = type === 'check-in' ? '{{ route("teacher.attendance.checkin") }}' : '{{ route("teacher.attendance.checkout") }}';
            const notes = document.getElementById('notes').value + ' [ADMIN OVERRIDE]';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Admin-Override': 'true'
                },
                body: JSON.stringify({
                    latitude: currentLocation.latitude,
                    longitude: currentLocation.longitude,
                    notes: notes,
                    admin_override: true
                })
            })
            .then(response => response.json())
            .then(data => {
                modal.classList.add('hidden');
                if (data.success) {
                    showSuccessMessage(data.message + ' (Admin Override)');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showErrorMessage(data.message);
                }
            })
            .catch(error => {
                modal.classList.add('hidden');
                showErrorMessage('Override gagal: ' + error.message);
            });
        }
        
        // PWA Installation Support
        let deferredPrompt;
        let installButton;
        
        // Listen for install prompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('PWA: Install prompt available');
            e.preventDefault();
            deferredPrompt = e;
            showInstallBanner();
        });
        
        // Show install banner
        function showInstallBanner() {
            const banner = document.getElementById('pwa-install-banner');
            if (banner) {
                banner.classList.remove('hidden');
                // Add pulse animation
                banner.classList.add('pulse-animation');
                setTimeout(() => banner.classList.remove('pulse-animation'), 3000);
            }
        }
        
        // Show install prompt (fallback)
        function showInstallPrompt() {
            const promptHtml = `
                <div class="install-prompt" id="install-prompt">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-mobile-alt text-2xl mr-3"></i>
                            <div>
                                <h4 class="font-bold">Install Aplikasi Absensi</h4>
                                <p class="text-sm opacity-90">Install sebagai aplikasi di home screen untuk akses lebih mudah</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="installPWA()" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 pulse-animation">
                                Install
                            </button>
                            <button onclick="hideInstallPrompt()" class="text-white opacity-75 hover:opacity-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', promptHtml);
            
            // Show prompt after 2 seconds
            setTimeout(() => {
                const prompt = document.getElementById('install-prompt');
                if (prompt) {
                    prompt.classList.add('show');
                }
            }, 2000);
        }
        
        // Install PWA
        window.installPWA = function() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((result) => {
                    console.log('PWA Install:', result.outcome);
                    deferredPrompt = null;
                    hideInstallPrompt();
                    // Hide banner
                    const banner = document.getElementById('pwa-install-banner');
                    if (banner) banner.style.display = 'none';
                });
            } else {
                // Show manual install instructions
                showManualInstallInstructions();
            }
        }
        
        // Show manual install instructions for iOS and other browsers
        function showManualInstallInstructions() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            
            let instructions = '';
            if (isIOS) {
                instructions = `
                    <strong>Cara Install di iPhone/iPad:</strong><br>
                    1. Tap tombol Share <i class="fas fa-share"></i> di Safari<br>
                    2. Pilih "Add to Home Screen"<br>
                    3. Tap "Add" untuk install aplikasi
                `;
            } else if (isAndroid) {
                instructions = `
                    <strong>Cara Install di Android:</strong><br>
                    1. Tap menu (⋮) di Chrome<br>
                    2. Pilih "Add to Home screen"<br>
                    3. Tap "Add" untuk install aplikasi
                `;
            } else {
                instructions = `
                    <strong>Cara Install:</strong><br>
                    1. Klik menu browser (⋮)<br>
                    2. Cari opsi "Install app" atau "Add to Home screen"<br>
                    3. Ikuti petunjuk untuk install
                `;
            }
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4';
            modal.innerHTML = `
                <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                    <h3 class="text-lg font-bold mb-4">📱 Install Aplikasi</h3>
                    <div class="text-sm text-gray-700 mb-6">${instructions}</div>
                    <button onclick="this.parentElement.parentElement.remove()" class="w-full bg-blue-600 text-white py-2 rounded-lg">
                        Mengerti
                    </button>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Hide install prompt
        window.hideInstallPrompt = function() {
            const prompt = document.getElementById('install-prompt');
            if (prompt) {
                prompt.classList.remove('show');
                setTimeout(() => prompt.remove(), 300);
            }
        }
        
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('SW registered: ', registration);
                        
                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // New update available
                                    showUpdateNotification();
                                }
                            });
                        });
                    })
                    .catch((registrationError) => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
        
        // Show update notification
        function showUpdateNotification() {
            const updateHtml = `
                <div class="install-prompt show" id="update-prompt">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-download text-2xl mr-3"></i>
                            <div>
                                <h4 class="font-bold">Update Tersedia</h4>
                                <p class="text-sm opacity-90">Versi baru aplikasi tersedia. Refresh untuk update?</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button onclick="window.location.reload()" class="bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100">
                                Update
                            </button>
                            <button onclick="document.getElementById('update-prompt').remove()" class="text-white opacity-75 hover:opacity-100">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', updateHtml);
        }
        
        // Enhanced location tracking for PWA
        function trackLocation() {
            if (navigator.geolocation) {
                // Watch position for better accuracy in PWA
                const watchId = navigator.geolocation.watchPosition(
                    (position) => {
                        currentLocation = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy,
                            timestamp: position.timestamp
                        };
                        updateLocationStatus(true);
                        enableButtons();
                    },
                    (error) => {
                        console.error('Location watch error:', error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000  // 1 minute cache for PWA
                    }
                );
                
                // Store watch ID for cleanup
                window.locationWatchId = watchId;
            }
        }
        
        // Cleanup location watch when leaving page
        window.addEventListener('beforeunload', () => {
            if (window.locationWatchId) {
                navigator.geolocation.clearWatch(window.locationWatchId);
            }
        });
        
        // Enhanced PWA experience when in standalone mode
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone) {
            console.log('Running in PWA mode');
            document.body.classList.add('pwa-mode');
            
            // Start location tracking for PWA
            setTimeout(trackLocation, 1000);
            
            // Show PWA welcome message
            setTimeout(() => {
                const welcome = document.createElement('div');
                welcome.className = 'fixed top-4 left-4 right-4 bg-green-600 text-white p-3 rounded-lg shadow-lg z-50';
                welcome.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="text-sm">Aplikasi berhasil terinstall! 🎉</span>
                    </div>
                `;
                document.body.appendChild(welcome);
                
                setTimeout(() => welcome.remove(), 3000);
            }, 500);
        }
    </script>
</body>
</html> 