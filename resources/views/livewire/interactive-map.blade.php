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
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">🗺️ Farm Location Map</h2>
            <button onclick="locateMe()"
    class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-all duration-200">
    📍Location
</button>

<!-- Modern Popup -->
<div id="location-popup" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    
    <!-- Popup Card -->
    <div class="relative z-10 bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center">
        
        <!-- Icon -->
        <div id="popup-icon" class="text-6xl mb-4">📍</div>
        
        <!-- Title -->
        <h3 id="popup-title" class="text-xl font-bold text-gray-800 dark:text-white mb-2">
            Finding Your Location
        </h3>
        
        <!-- Message -->
        <p id="popup-message" class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            Please allow location access when prompted by your browser.
        </p>

        <!-- Loading Bar -->
        <div id="popup-loading" class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-2 mb-6">
            <div id="loading-bar" class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: 0%"></div>
        </div>

        <!-- Button -->
        <button id="popup-close" onclick="closeLocationPopup()"
            class="hidden px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
            Got it!
        </button>
    </div>
</div>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Click anywhere on the map to get weather data for that location.</p>
        
        <!-- Location Info -->
    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 text-sm font-medium mb-3">
        📍 <span id="current-location-name">{{ $locationName ?? 'Batac City' }}</span>
        (<span id="current-lat">{{ number_format($lat, 4) }}</span>, 
        <span id="current-lon">{{ number_format($lon, 4) }}</span>)
    </div>

        <div wire:ignore>
            <div id="map" style="height: 300px;" class="rounded-xl z-0"
            x-data 
    x-init="$el.style.height = window.innerWidth < 768 ? '250px' : '400px'">>
        </div>
    </div>

    @if($error)
        <div class="mt-4 p-4 rounded-xl border border-red-300 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
            ⚠️ {{ $error }}
        </div>
    @endif

    <!-- Alert Banner -->
    <div class="flex items-center gap-3 rounded-xl border border-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-700 p-4 mt-4">
        <span class="text-yellow-600 dark:text-yellow-400 text-xl">⚠️</span>
        <div>
            <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">No Active Weather Alerts</p>
            <p class="text-xs text-yellow-600 dark:text-yellow-500">System is monitoring weather conditions continuously.</p>
        </div>
    </div>

    <!-- Farm Activities (Pending & In Progress only) -->
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
                        <th class="px-4 py-3">Start Date</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr class="border-b dark:border-neutral-700">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</td>
                        <td class="px-4 py-3">{{ $activity->type }}</td>
                        <td class="px-4 py-3">{{ $activity->location ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $activity->started_at?->format('M d, Y') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($activity->status === 'In Progress')
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
                    <th class="px-4 py-3">Started</th>
                    <th class="px-4 py-3">Ended</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($completedActivities as $activity)
                <tr class="border-b dark:border-neutral-700">
                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $activity->title }}</td>
                    <td class="px-4 py-3">{{ $activity->type }}</td>
                    <td class="px-4 py-3">{{ $activity->location ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->started_at ? $activity->started_at->format('M d, Y') : '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->ended_at ? $activity->ended_at->format('M d, Y') : '-' }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="delete({{ $activity->id }})"
                            wire:confirm="Are you sure you want to delete this activity?"
                            class="text-red-500 hover:text-red-700 text-xs">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                        ✅ No completed activities yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            
</div>

    <script>
    function updateLocationDisplay(lat, lon, name) {
        var locationName = document.getElementById('current-location-name');
        var currentLat = document.getElementById('current-lat');
        var currentLon = document.getElementById('current-lon');

        if (locationName) locationName.textContent = name || 'Unknown Location';
        if (currentLat) currentLat.textContent = lat.toFixed(4);
        if (currentLon) currentLon.textContent = lon.toFixed(4);
    }

    function showLocationPopup(icon, title, message, showClose, isError) {
        var popup = document.getElementById('location-popup');
        var popupIcon = document.getElementById('popup-icon');
        var popupTitle = document.getElementById('popup-title');
        var popupMessage = document.getElementById('popup-message');
        var popupClose = document.getElementById('popup-close');
        var popupLoading = document.getElementById('popup-loading');
        var loadingBar = document.getElementById('loading-bar');

        popupIcon.textContent = icon;
        popupTitle.textContent = title;
        popupMessage.textContent = message;

        if (showClose) {
            popupClose.classList.remove('hidden');
            popupLoading.classList.add('hidden');
        } else {
            popupClose.classList.add('hidden');
            popupLoading.classList.remove('hidden');
            setTimeout(function() {
                loadingBar.style.width = '90%';
            }, 100);
        }

        if (isError) {
            popupTitle.classList.add('text-red-500');
            popupTitle.classList.remove('text-gray-800');
        } else {
            popupTitle.classList.remove('text-red-500');
            popupTitle.classList.add('text-gray-800');
        }

        popup.classList.remove('hidden');
    }

    function closeLocationPopup() {
        var popup = document.getElementById('location-popup');
        var loadingBar = document.getElementById('loading-bar');
        popup.classList.add('hidden');
        loadingBar.style.width = '0%';
    }

    function fetchLocationName(lat, lon, callback) {
        fetch('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lon + '&format=json')
            .then(function(response) { return response.json(); })
            .then(function(data) {
                var name = data.address.city 
                    || data.address.town 
                    || data.address.village 
                    || data.address.municipality
                    || data.address.county
                    || 'Unknown Location';
                callback(name);
            })
            .catch(function() {
                callback('Unknown Location');
            });
    }

    function locateMe() {
        if (!navigator.geolocation) {
            showLocationPopup('❌', 'Not Supported', 'Geolocation is not supported by your browser.', true, true);
            return;
        }

        showLocationPopup('📍', 'Finding Your Location...', 'Please allow location access when prompted by your browser.', false, false);

        navigator.geolocation.getCurrentPosition(
            function(position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                if (window.mapInstance) {
                    window.mapInstance.setView([lat, lon], 15);
                }

                fetchLocationName(lat, lon, function(name) {
                    if (window.mapMarker) {
                        window.mapMarker.setLatLng([lat, lon]);
                        window.mapMarker.bindPopup('📍 ' + name).openPopup();
                    }

                    updateLocationDisplay(lat, lon, name);
                    Livewire.dispatch('updateLocation', { lat: lat, lon: lon });

                    var loadingBar = document.getElementById('loading-bar');
                    loadingBar.style.width = '100%';

                    setTimeout(function() {
                        showLocationPopup('✅', 'Location Found!', 'Weather data updated for ' + name + '.', true, false);
                    }, 500);
                });
            },
            function(error) {
                var message = 'Unable to get your location.';
                if (error.code === 1) message = 'Location access was denied. Please allow location access in your browser settings.';
                if (error.code === 2) message = 'Location unavailable. Please try again.';
                if (error.code === 3) message = 'Location request timed out. Please try again.';
                showLocationPopup('❌', 'Location Error', message, true, true);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function initMap() {
        var mapContainer = document.getElementById('map');
        if (!mapContainer) return;

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

        window.mapMarker = marker;

        map.on('click', function (e) {
            var clickLat = e.latlng.lat;
            var clickLon = e.latlng.lng;

            fetchLocationName(clickLat, clickLon, function(name) {
                marker.setLatLng([clickLat, clickLon]);
                marker.bindPopup('📍 ' + name).openPopup();
                updateLocationDisplay(clickLat, clickLon, name);
                Livewire.dispatch('updateLocation', { lat: clickLat, lon: clickLon });
            });
        });

        window.mapInstance = map;

        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    }

    document.addEventListener('livewire:initialized', initMap);
    document.addEventListener('livewire:navigated', initMap);
</script>