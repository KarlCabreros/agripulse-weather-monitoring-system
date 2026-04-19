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

    <!-- Map Container -->
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-4 mt-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3">🗺️ Farm Location Map</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Click anywhere on the map to get weather data for that location.</p>
        
        <!-- Location -->
        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm font-medium mb-3">
            📍 {{ $locationName ?? 'Batac City' }}
            ({{ number_format($lat, 4) }}, {{ number_format($lon, 4) }})
        </div>

        <div wire:ignore>
            <div id="map" style="height: 400px;" class="rounded-xl z-0"></div>
        </div>
    </div>

    @if($error)
        <div class="mt-4 p-4 rounded-xl border border-red-300 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
            ⚠️ {{ $error }}
        </div>
    @endif

    <!-- Alert Banner -->
    <div wire:ignore class="flex items-center gap-3 rounded-xl border border-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-700 p-4 mt-4">
        <span class="text-yellow-600 dark:text-yellow-400 text-xl">⚠️</span>
        <div>
            <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">No Active Weather Alerts</p>
            <p class="text-xs text-yellow-600 dark:text-yellow-500">System is monitoring weather conditions continuously.</p>
        </div>
    </div>

<!-- Farm Activities (All statuses, view only) -->
<div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6 mt-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">📋 Farm Activities</h2>
        <a href="{{ route('farm-activities') }}" class="text-sm text-green-600 hover:underline">Manage Activities</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-neutral-700">
                <tr>
                    <th class="px-4 py-3">Activity</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr class="border-b dark:border-neutral-700">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</td>
                    <td class="px-4 py-3">{{ $activity->type }}</td>
                    <td class="px-4 py-3">{{ $activity->location ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->activity_date->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        @if($activity->status === 'Completed')
                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Completed</span>
                        @elseif($activity->status === 'In Progress')
                            <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">In Progress</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                        🌱 No farm activities yet.
                        <a href="{{ route('farm-activities') }}" class="text-green-600 hover:underline">Add one now!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Farm Activities (Completed only, with delete) -->
<div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6 mt-4">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">✅ Recent Farm Activities</h2>
        <span class="text-xs text-gray-400 dark:text-gray-500">Auto-deletes after 7 days</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-neutral-700">
                <tr>
                    <th class="px-4 py-3">Activity</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completedActivities as $activity)
                <tr class="border-b dark:border-neutral-700">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</td>
                    <td class="px-4 py-3">{{ $activity->type }}</td>
                    <td class="px-4 py-3">{{ $activity->location ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->activity_date->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="delete({{ $activity->id }})" 
                            wire:confirm="Are you sure you want to delete this activity?"
                            class="text-red-500 hover:text-red-700 text-xs">
                            🗑️ Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                        ✅ No completed activities yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        function initMap() {
            if (window.mapInstance) {
                window.mapInstance.remove();
                window.mapInstance = null;
            }

            var lat = parseFloat('{{ $lat }}');
            var lon = parseFloat('{{ $lon }}');
            var locationName = '{{ $locationName ?? "Batac City" }}';

            var map = L.map('map').setView([lat, lon], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([lat, lon]).addTo(map)
                .bindPopup('📍 ' + locationName)
                .openPopup();

            map.on('click', function (e) {
                var clickLat = e.latlng.lat;
                var clickLon = e.latlng.lng;
                marker.setLatLng([clickLat, clickLon]);
                Livewire.dispatch('updateLocation', { lat: clickLat, lon: clickLon });
            });

            window.mapInstance = map;

            setTimeout(function() {
            map.invalidateSize();
        }, 100);
        }

        document.addEventListener('livewire:initialized', initMap);
        document.addEventListener('livewire:navigated', initMap);
    </script>
</div>