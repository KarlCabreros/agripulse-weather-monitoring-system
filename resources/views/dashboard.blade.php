<x-layouts::app :title="__('Dashboard')">
    <div class="flex w-full flex-col gap-4 rounded-xl">
        
        <!-- Page Title -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-sucess">AgriPulse Dashboard</h1>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ now()->timezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
        </div>

        <!-- Interactive Map with Weather -->
        @livewire('interactive-map')

    </div>
</x-layouts::app>
