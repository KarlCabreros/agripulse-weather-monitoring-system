<div>
    <!-- Weather Cards -->
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        
        <!-- Temperature -->
        <div class="flex flex-col gap-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                🌡️ Temperature
            </div>
            <div class="text-4xl font-bold text-orange-500">
                {{ $temperature !== null ? $temperature . '°C' : '--°C' }}
            </div>
            <div class="text-sm text-gray-400">
                {{ $weatherDescription ?? 'Fetching weather data...' }}
            </div>
        </div>

        <!-- Humidity -->
        <div class="flex flex-col gap-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                💧 Humidity
            </div>
            <div class="text-4xl font-bold text-blue-500">
                {{ $humidity !== null ? $humidity . '%' : '--%' }}
            </div>
            <div class="text-sm text-gray-400">Relative Humidity</div>
        </div>

        <!-- Wind Speed -->
        <div class="flex flex-col gap-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
            <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                💨 Wind Speed
            </div>
            <div class="text-4xl font-bold text-green-500">
                {{ $windSpeed !== null ? $windSpeed . ' m/s' : '-- m/s' }}
            </div>
            <div class="text-sm text-gray-400">Current Wind Speed</div>
        </div>

    </div>

    <!-- Error Message -->
    @if($error)
        <div class="mt-4 p-4 rounded-xl border border-red-300 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
            ⚠️ {{ $error }}
        </div>
    @endif
</div>