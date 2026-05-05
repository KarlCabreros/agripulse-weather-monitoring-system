<div>
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl md:text-2xl font-bold text-green-600 dark:text-green-600">Farm Activities</h1>

        @if(Auth::user()->canManageActivities())
            <button wire:click="toggleForm" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                @if($showForm)
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                    <span>Cancel</span>
                @else
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                    </svg>
                    <span>Add Activity</span>
                @endif
            </button>
        @endif
    </div>

    <!-- Form -->
    @if($showForm)
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-5 md:p-6 mb-4">
            <h2 class="flex items-center gap-2 text-base md:text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">
                @if($editingId)
                    <svg class="size-5 text-green-600 dark:text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.651-1.651a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                    </svg>
                    <span>Edit Activity</span>
                @else
                    <svg class="size-5 text-green-600 dark:text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                    </svg>
                    <span>Add New Activity</span>
                @endif
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Title</label>
                    <input wire:model="title" type="text" placeholder="e.g. Rice Field Irrigation"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                    <select wire:model="type"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option>Planting</option>
                        <option>Fertilizing</option>
                        <option>Irrigation</option>
                        <option>Harvesting</option>
                        <option>Pest Control</option>
                        <option>Other</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Ended At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ended At</label>
                    <input wire:model="ended_at" type="date"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                    @error('ended_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Started At -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Started At</label>
                    <input wire:model="started_at" type="date"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                    @error('started_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                    <input wire:model="location" type="text" placeholder="e.g. Field A, North Farm"
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea wire:model="description" placeholder="Additional details..."
                        class="w-full rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-600" rows="2"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button wire:click="save" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    <span>{{ $editingId ? 'Update Activity' : 'Save Activity' }}</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Activities Table -->
    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-5 md:p-6">
        @if($activities->isEmpty())
            <div class="flex flex-col items-center justify-center py-10 text-center text-gray-500 dark:text-gray-400">
                <span class="mb-3 inline-flex size-12 items-center justify-center rounded-full bg-green-600 text-white">
                    <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M12 12.75c0-3.25 2.65-5.9 5.9-5.9H21v3.1c0 3.25-2.65 5.9-5.9 5.9H12Zm0 0c0-3.25-2.65-5.9-5.9-5.9H3v3.1c0 3.25 2.65 5.9 5.9 5.9H12Z" />
                    </svg>
                </span>
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
                            <th class="px-4 py-3">Started</th>
                            <th class="px-4 py-3">Ended</th>
                            <th class="px-4 py-3">Status</th>
                            @if(Auth::user()->canManageActivities())
                                <th class="px-4 py-3">Actions</th>
                            @endif
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
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        Completed
                                    </span>
                                @elseif($activity->status === 'In Progress')
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        In Progress
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            @if(Auth::user()->canManageActivities())
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="edit({{ $activity->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition"
                                    >
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.651-1.651a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        wire:click="delete({{ $activity->id }})"
                                        wire:confirm="Are you sure you want to delete this activity?"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-medium transition"
                                    >
                                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79 18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .563c.34-.059.68-.114 1.022-.166m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
