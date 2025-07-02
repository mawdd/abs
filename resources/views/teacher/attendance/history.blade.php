<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Absensi - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Riwayat Absensi</h1>
                    <p class="text-gray-600">{{ auth()->user()->name }}</p>
                </div>
                <a href="{{ route('teacher.attendance') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Month Filter -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" class="flex items-center space-x-4">
                <label for="month" class="font-medium text-gray-700">Pilih Bulan:</label>
                <input 
                    type="month" 
                    id="month" 
                    name="month" 
                    value="{{ $month }}"
                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
            </form>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Hari Hadir</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $attendances->where('status', 'present')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Terlambat</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $attendances->where('status', 'late')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Tidak Hadir</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $attendances->where('status', 'absent')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Detail Absensi</h2>
            </div>

            @if($attendances->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($attendances as $attendance)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $attendance->date->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $attendance->date->format('l') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->check_in_time)
                                            <div class="text-sm text-gray-900">{{ $attendance->check_in_time->format('H:i:s') }}</div>
                                            <div class="flex items-center text-xs">
                                                @if($attendance->check_in_location_valid)
                                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                    <span class="text-green-600">Valid</span>
                                                @else
                                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                                                    <span class="text-yellow-600">Di luar area</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->check_out_time)
                                            <div class="text-sm text-gray-900">{{ $attendance->check_out_time->format('H:i:s') }}</div>
                                            <div class="flex items-center text-xs">
                                                @if($attendance->check_out_location_valid)
                                                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                    <span class="text-green-600">Valid</span>
                                                @else
                                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i>
                                                    <span class="text-yellow-600">Di luar area</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'present' => 'bg-green-100 text-green-800',
                                                'late' => 'bg-yellow-100 text-yellow-800', 
                                                'absent' => 'bg-red-100 text-red-800'
                                            ];
                                            $statusLabels = [
                                                'present' => 'Hadir',
                                                'late' => 'Terlambat',
                                                'absent' => 'Tidak Hadir'
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$attendance->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$attendance->status] ?? ucfirst($attendance->status) }}
                                        </span>
                                        @if($attendance->is_holiday)
                                            <div class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                Hari libur
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($attendance->check_in_location_valid && $attendance->check_out_location_valid)
                                            <i class="fas fa-check-circle text-green-500"></i>
                                        @elseif($attendance->check_in_location_valid || $attendance->check_out_location_valid)
                                            <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                                        @else
                                            <i class="fas fa-times-circle text-red-500"></i>
                                        @endif
                                    </td>
                                </tr>
                                @if($attendance->notes)
                                    <tr class="bg-gray-50">
                                        <td colspan="5" class="px-6 py-2">
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-sticky-note mr-2"></i>
                                                <strong>Catatan:</strong> {{ $attendance->notes }}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data</h3>
                    <p class="text-gray-500">Belum ada data absensi untuk bulan ini.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html> 