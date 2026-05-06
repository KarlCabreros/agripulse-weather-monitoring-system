<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AgriPulse - Smart Agriculture Management System</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            document.documentElement.classList.add('dark');
        </script>
    </head>
    <body class="min-h-screen bg-zinc-900 text-white flex flex-col">

        <!-- Navbar -->
        <nav class="flex items-center justify-between px-8 py-4 border-b border-zinc-800">
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-green-600">AgriPulse</span>
            </div>
            <div class="flex items-center gap-4">
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center px-8 py-20 text-center">
            <div class="max-w-3xl">
                <h1 class="text-5xl font-bold text-white mb-4">
                    Smart Agriculture
                    <span class="text-green-600">Management System</span>
                </h1>
                <p class="text-lg text-gray-400 mb-8 max-w-2xl mx-auto">
                    AgriPulse helps farmers and farm managers make data-driven decisions with real-time weather analytics, automated alerts, and centralized farm activity logging.
                </p>
                <div class="flex items-center justify-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-lg">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium text-lg">
                            Get Started Free
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-3 border border-zinc-600 hover:border-zinc-400 text-gray-300 hover:text-white rounded-lg font-medium text-lg">
                            Log in
                        </a>
                    @endauth
                </div>
            </div>
        </main>

        <!-- Features Section -->
        <section class="px-8 py-16 border-t border-zinc-800">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-white mb-12">Key Features</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Feature 1 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Real-Time Weather Dashboard</h3>
                        <p class="text-sm text-gray-400">Displays live temperature, humidity, and wind speed specific to your farm's GPS coordinates using OpenWeatherMap API.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Farm Activity Logging</h3>
                        <p class="text-sm text-gray-400">Centralized module for recording and tracking planting dates, fertilizer applications, and irrigation schedules.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Critical Weather Alerts</h3>
                        <p class="text-sm text-gray-400">Automated monitoring that triggers instant notifications to Discord or Telegram when safety thresholds are breached.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Interactive Farm Map</h3>
                        <p class="text-sm text-gray-400">Click anywhere on the map to get real-time weather data for that specific location using GPS coordinates.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Multi-Platform Notifications</h3>
                        <p class="text-sm text-gray-400">Pushes formatted emergency warnings to Discord channels or Telegram groups to reach field personnel instantly.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-zinc-800 rounded-xl p-6 border border-zinc-700">
                        <h3 class="text-lg font-semibold text-white mb-2">Secure Authentication</h3>
                        <p class="text-sm text-gray-400">Robust login and registration system for different farm personnel to protect data integrity and maintain audit trails.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="px-8 py-6 border-t border-zinc-800 text-center">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} AgriPulse — Smart Agriculture Management System | all rights reserved. <br>
            </p>
        </footer>

    </body>
</html>
