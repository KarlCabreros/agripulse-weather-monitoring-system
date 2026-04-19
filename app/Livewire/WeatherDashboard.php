<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class WeatherDashboard extends Component
{
    public $temperature = null;
    public $humidity = null;
    public $windSpeed = null;
    public $weatherDescription = null;
    public $error = null;

    public function mount()
    {
        $this->fetchWeather();
    }

    public function fetchWeather()
    {
        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $lat = env('OPENWEATHER_LAT', 18.0647);
            $lon = env('OPENWEATHER_LON', 120.6200);

            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->temperature = round($data['main']['temp']);
                $this->humidity = $data['main']['humidity'];
                $this->windSpeed = $data['wind']['speed'];
                $this->weatherDescription = $data['weather'][0]['description'];
            } else {
                $this->error = 'Failed to fetch weather data.';
            }
        } catch (\Exception $e) {
            $this->error = 'Error: ' . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.weather-dashboard');
    }
}
