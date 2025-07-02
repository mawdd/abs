<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi Guru - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-md">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Absensi Guru</h1>
                <p class="text-gray-600">{{ auth()->user()->name }}</p>
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
                    <button 
                        id="request-gps-btn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium w-full"
                    >
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Coba Lagi GPS
                    </button>
                    
                    <div class="text-xs text-gray-500">
                        Klik tombol di atas, lalu pilih "Allow" atau "Izinkan" saat browser meminta akses lokasi
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

        // Auto-request GPS permission on page load
        window.addEventListener('load', function() {
            requestLocation();
        });

        // Function to request location
        function requestLocation() {
            if (!navigator.geolocation) {
                updateLocationStatus(false, 'Geolocation tidak didukung browser');
                return;
            }

            // Show loading state
            updateLocationStatus(null, 'Meminta akses lokasi...');
            
            // Add timeout indicator
            let timeoutCounter = 0;
            const timeoutIndicator = setInterval(() => {
                timeoutCounter += 1;
                if (timeoutCounter <= 15) {
                    updateLocationStatus(null, `Mencari sinyal GPS... (${timeoutCounter}s)`);
                } else {
                    clearInterval(timeoutIndicator);
                }
            }, 1000);
            
            // Try high accuracy first, then fallback to low accuracy
            const highAccuracyOptions = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000  // 5 minutes cache
            };
            
            const lowAccuracyOptions = {
                enableHighAccuracy: false,
                timeout: 5000,
                maximumAge: 300000  // 5 minutes cache
            };
            
            // First attempt with high accuracy
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    currentLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };
                    
                    console.log('GPS Success (High Accuracy):', currentLocation);
                    clearInterval(timeoutIndicator);
                    updateLocationStatus(true);
                    enableButtons();
                    hideGpsRequestSection();
                },
                function(error) {
                    console.log('High accuracy failed, trying low accuracy...', error);
                    
                    // Fallback to low accuracy
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            currentLocation = {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                accuracy: position.coords.accuracy
                            };
                            
                            console.log('GPS Success (Low Accuracy):', currentLocation);
                            clearInterval(timeoutIndicator);
                            updateLocationStatus(true, 'Lokasi ditemukan (akurasi rendah)');
                            enableButtons();
                            hideGpsRequestSection();
                        },
                        function(error) {
                            console.error('Both GPS attempts failed:', error);
                            clearInterval(timeoutIndicator);
                            
                            let errorMessage = 'Gagal mengambil lokasi';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage = 'Akses lokasi ditolak. Klik tombol "Izinkan Akses Lokasi" di bawah.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage = 'GPS tidak tersedia. Coba di area terbuka.';
                                    break;
                                case error.TIMEOUT:
                                    errorMessage = 'Timeout. Coba lagi atau pindah ke area dengan sinyal GPS lebih baik.';
                                    break;
                            }
                            
                            updateLocationStatus(false, errorMessage);
                            showGpsRequestSection();
                        },
                        lowAccuracyOptions
                    );
                },
                highAccuracyOptions
            );
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
            // Double check location validation
            if (!validateCurrentLocation()) {
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
                
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                modal.classList.add('hidden');
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    </script>
</body>
</html> 