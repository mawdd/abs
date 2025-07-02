<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Sistem Absensi Guru</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg text-center">
        <div class="mb-6">
            <i class="fas fa-wifi-slash text-6xl text-red-500 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Mode Offline</h1>
            <p class="text-gray-600">Tidak ada koneksi internet</p>
        </div>
        
        <div class="mb-6 text-left bg-blue-50 p-4 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">ℹ️ Informasi:</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Sistem absensi memerlukan koneksi internet</li>
                <li>• GPS dan validasi lokasi tidak dapat berfungsi offline</li>
                <li>• Silakan sambungkan ke internet untuk melanjutkan</li>
            </ul>
        </div>
        
        <div class="space-y-3">
            <button 
                onclick="window.location.reload()" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium"
            >
                <i class="fas fa-sync-alt mr-2"></i>
                Coba Lagi
            </button>
            
            <button 
                onclick="checkConnection()" 
                class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded-lg font-medium"
            >
                <i class="fas fa-globe mr-2"></i>
                Periksa Koneksi
            </button>
        </div>
        
        <div class="mt-6 text-xs text-gray-500">
            <p>Aplikasi Absensi Guru - PWA Mode</p>
        </div>
    </div>

    <script>
        function checkConnection() {
            if (navigator.onLine) {
                alert('Koneksi internet tersedia! Silakan refresh halaman.');
                window.location.reload();
            } else {
                alert('Masih tidak ada koneksi internet. Pastikan WiFi atau data seluler aktif.');
            }
        }
        
        // Auto-check connection every 30 seconds
        setInterval(() => {
            if (navigator.onLine) {
                console.log('Connection restored, redirecting...');
                window.location.href = '/teacher/attendance';
            }
        }, 30000);
        
        // Listen for online event
        window.addEventListener('online', () => {
            console.log('Back online!');
            setTimeout(() => {
                window.location.href = '/teacher/attendance';
            }, 1000);
        });
    </script>
</body>
</html> 