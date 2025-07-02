<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
            <h2 class="text-xl font-bold tracking-tight">
                Test Teacher Panel
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                Teacher panel berhasil dimuat! Waktu: {{ now()->format('H:i:s d/m/Y') }}
            </p>
            <div class="mt-4">
                <p>✅ Laravel berfungsi</p>
                <p>✅ Filament Teacher Panel berfungsi</p>
                <p>✅ Authentication berfungsi</p>
            </div>
        </div>
    </div>
</x-filament-panels::page> 