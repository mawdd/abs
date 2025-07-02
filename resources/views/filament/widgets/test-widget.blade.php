<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold text-green-600 mb-4">🎉 Widget Test Berhasil!</h2>
    <p class="text-gray-600">Jika Anda melihat widget ini, berarti sistem widget Filament sudah berfungsi dengan baik.</p>
    <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
        <div class="flex items-center">
            <div class="text-green-500 mr-3">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <p class="text-green-800 font-semibold">Dashboard widgets siap digunakan!</p>
                <p class="text-green-700 text-sm">Data: {{ \App\Models\Attendance::count() }} attendance records</p>
            </div>
        </div>
    </div>
</div> 