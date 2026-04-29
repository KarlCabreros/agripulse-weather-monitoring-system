<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-green-700 dark:text-green-400">🌾 Farm Activities</h1>
        <button wire:click="toggleForm" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
            {{ $showForm ? 'Cancel' : '+ Add Activity' }}
        </button>
    </div>

    <!-- Form -->
    @if($showForm)
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6 mb-4">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
            {{ $editingId ? '✏️ Edit Activity' : '➕ Add New Activity' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Title</label>
                <input wire:model="title" type="text" placeholder="e.g. Rice Field Irrigation"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select wire:model="type"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option>Planting</option>
                    <option>Fertilizing</option>
                    <option>Irrigation</option>
                    <option>Harvesting</option>
                    <option>Pest Control</option>
                    <option>Other</option>
                </select>
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select wire:model="status"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

                        <!-- Ended At -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ended At</label>
                <input wire:model="ended_at" type="date"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('ended_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Started At -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Started At</label>
                <input wire:model="started_at" type="date"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('started_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <input wire:model="location" type="text" placeholder="e.g. Field A, North Farm"
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea wire:model="description" placeholder="Additional details..."
                    class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500" rows="2"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-4">
            <button wire:click="save" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium">
                {{ $editingId ? 'Update Activity' : 'Save Activity' }}
            </button>
        </div>
    </div>
    @endif

    <!-- Activities Table -->
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
        @if($activities->isEmpty())
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <p class="text-4xl mb-2">🌱</p>
                <p class="text-sm">No farm activities yet. Click "Add Activity" to get started!</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-neutral-700">
                        <tr>
                            <th class="px-4 py-3">Activity</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Location</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Started</th>
                            <th class="px-4 py-3">Ended</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr class="border-b dark:border-neutral-700">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $activity->title }}
                                @if($activity->description)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $activity->type }}</td>
                            <td class="px-4 py-3">{{ $activity->location ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $activity->started_at ? $activity->started_at->format('M d, Y') : '-' }}</td>
                            <td class="px-4 py-3">{{ $activity->ended_at ? $activity->ended_at->format('M d, Y') : '-' }}</td>
                            <td class="px-4 py-3">
                                @if($activity->status === 'Completed')
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Completed</span>
                                @elseif($activity->status === 'In Progress')
                                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">In Progress</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <button wire:click="edit({{ $activity->id }})" class="text-blue-500 hover:text-blue-700 text-xs mr-2">Edit</button>
                                <button wire:click="delete({{ $activity->id }})" wire:confirm="Are you sure you want to delete this activity?" class="text-red-500 hover:text-red-700 text-xs">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>