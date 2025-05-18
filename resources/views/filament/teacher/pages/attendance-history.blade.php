<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-white rounded-xl shadow dark:bg-gray-800">
            <h2 class="text-xl font-bold tracking-tight">
                Attendance History
            </h2>
            <p class="text-gray-500 dark:text-gray-400">
                View your past attendance records
            </p>
        </div>

        {{ $this->table }}
    </div>
</x-filament-panels::page> 