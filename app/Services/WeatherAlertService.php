<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherAlertService
{
    public function checkAndAlert($temperature, $humidity, $windSpeed, $locationName)
    {
        $alerts = [];

        $maxTemp = env('WEATHER_ALERT_TEMP', 35);
        $maxHumidity = env('WEATHER_ALERT_HUMIDITY', 90);
        $maxWind = env('WEATHER_ALERT_WIND', 10);

        if ($temperature >= $maxTemp) {
            $alerts[] = "🌡️ **High Temperature Alert!** Current: {$temperature}°C (Threshold: {$maxTemp}°C)";
        }

        if ($humidity >= $maxHumidity) {
            $alerts[] = "💧 **High Humidity Alert!** Current: {$humidity}% (Threshold: {$maxHumidity}%)";
        }

        if ($windSpeed >= $maxWind) {
            $alerts[] = "💨 **High Wind Speed Alert!** Current: {$windSpeed} m/s (Threshold: {$maxWind} m/s)";
        }

        if (!empty($alerts)) {
            $this->sendDiscordAlert($alerts, $temperature, $humidity, $windSpeed, $locationName);
            return true;
        }

        return false;
    }

    private function sendDiscordAlert($alerts, $temperature, $humidity, $windSpeed, $locationName)
    {
        $webhookUrl = env('DISCORD_WEBHOOK_URL');

        if (!$webhookUrl) return;

        $alertText = implode("\n", $alerts);

        $payload = [
            'username' => 'AgriPulse Alert System',
            'avatar_url' => 'https://cdn-icons-png.flaticon.com/512/2909/2909769.png',
            'embeds' => [
                [
                    'title' => '⚠️ CRITICAL WEATHER ALERT - AgriPulse',
                    'description' => $alertText,
                    'color' => 16711680,
                    'fields' => [
                        [
                            'name' => '📍 Location',
                            'value' => $locationName ?? 'Batac City',
                            'inline' => true,
                        ],
                        [
                            'name' => '🌡️ Temperature',
                            'value' => "{$temperature}°C",
                            'inline' => true,
                        ],
                        [
                            'name' => '💧 Humidity',
                            'value' => "{$humidity}%",
                            'inline' => true,
                        ],
                        [
                            'name' => '💨 Wind Speed',
                            'value' => "{$windSpeed} m/s",
                            'inline' => true,
                        ],
                        [
                            'name' => '⏰ Time',
                            'value' => now()->timezone('Asia/Manila')->format('F d, Y h:i A'),
                            'inline' => true,
                        ],
                    ],
                    'footer' => [
                        'text' => 'AgriPulse - Smart Agriculture Management System',
                    ],
                    'timestamp' => now()->toIso8601String(),
                ]
            ]
        ];

        Http::withoutVerifying()->post($webhookUrl, $payload);
    }
}