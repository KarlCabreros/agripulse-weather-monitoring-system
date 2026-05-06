<?php

namespace App\Livewire;

use App\Models\FarmActivity;
use App\Services\WeatherAlertService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class InteractiveMap extends Component
{
    public $lat = 18.0647;
    public $lon = 120.6200;
    public $temperature = null;
    public $humidity = null;
    public $windSpeed = null;
    public $weatherDescription = null;
    public $locationName = null;
    public $error = null;
    public $hasAlert = false;
    public $alertMessages = [];

    public function mount()
    {
        $this->loadSavedLocation();
        $this->fetchWeather();
        $this->autoDeleteCompleted();
    }

    public function autoDeleteCompleted()
    {
        FarmActivity::where('user_id', Auth::id())
            ->where('status', 'Completed')
            ->where('updated_at', '<=', now()->subDays(7))
            ->delete();
    }

    #[On('updateLocation')]
    public function updateLocation($lat, $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->fetchWeather();
    }

    public function fetchWeather()
    {
        try {
            $apiKey = env('OPENWEATHER_API_KEY');

            $response = Http::withoutVerifying()->get('https://api.openweathermap.org/data/2.5/weather', [
                'lat' => $this->lat,
                'lon' => $this->lon,
                'appid' => $apiKey,
                'units' => 'metric',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->temperature = round($data['main']['temp']);
                $this->humidity = $data['main']['humidity'];
                $this->windSpeed = $data['wind']['speed'];
                $this->weatherDescription = $data['weather'][0]['description'];
                $this->locationName = $data['name'];
                $this->error = null;
                $this->saveCurrentLocation();

                $alertService = new WeatherAlertService();
                $this->hasAlert = $alertService->checkAndAlert(
                    $this->temperature,
                    $this->humidity,
                    $this->windSpeed,
                    $this->locationName
                );

                $this->alertMessages = [];
                if ($this->temperature >= env('WEATHER_ALERT_TEMP', 35)) {
                    $this->alertMessages[] = "High Temperature: {$this->temperature}°C";
                }
                if ($this->humidity >= env('WEATHER_ALERT_HUMIDITY', 90)) {
                    $this->alertMessages[] = "High Humidity: {$this->humidity}%";
                }
                if ($this->windSpeed >= env('WEATHER_ALERT_WIND', 10)) {
                    $this->alertMessages[] = "High Wind Speed: {$this->windSpeed} m/s";
                }
            } else {
                $this->error = 'Failed to fetch weather data.';
            }
        } catch (\Exception $e) {
            $this->error = 'Error: '.$e->getMessage();
        }
    }

    public function delete($id)
    {
        FarmActivity::find($id)->delete();
    }

    private function loadSavedLocation(): void
    {
        $location = session($this->locationSessionKey());

        if (! is_array($location)) {
            return;
        }

        $this->lat = (float) ($location['lat'] ?? $this->lat);
        $this->lon = (float) ($location['lon'] ?? $this->lon);
        $this->locationName = $location['name'] ?? $this->locationName;
    }

    private function saveCurrentLocation(): void
    {
        session()->put($this->locationSessionKey(), [
            'lat' => $this->lat,
            'lon' => $this->lon,
            'name' => $this->locationName,
        ]);
    }

    private function locationSessionKey(): string
    {
        return 'interactive_map.location.'.(Auth::id() ?? 'guest');
    }

    public function render()
    {
        $activities = FarmActivity::query()
            ->whereIn('status', ['Pending', 'In Progress'])
            ->orderByDesc('started_at')
            ->orderByDesc('created_at')
            ->get();

        $completedActivities = FarmActivity::query()
            ->where('status', 'Completed')
            ->orderByDesc('started_at')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.interactive-map', compact('activities', 'completedActivities'));
    }
}
