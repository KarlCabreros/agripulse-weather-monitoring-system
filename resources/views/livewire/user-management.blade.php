
<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-green-700 dark:text-green-400">User Management</h1>
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Joined</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b dark:border-neutral-700">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                            {{ $user->name }}
                            @if($user->id === Auth::id())
                                <span class="text-xs text-green-500">(You)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($editingId === $user->id)
                                <select wire:model="editingRole"
                                    class="rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-gray-900 dark:text-gray-100 px-2 py-1 text-xs">
                                    <option value="owner">Owner</option>
                                    <option value="manager">Manager</option>
                                    <option value="worker">Worker</option>
                                </select>
                            @else
                                @if($user->role === 'owner')
                                    <span class="px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-700">Owner</span>
                                @elseif($user->role === 'manager')
                                    <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">Manager</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">Worker</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            @if($user->id !== Auth::id())
                                @if($editingId === $user->id)
                                    <div class="flex items-center gap-2">
                                        <button wire:click="updateRole({{ $user->id }})" class="px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition">Save</button>
                                        <button wire:click="cancelEdit" class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-medium transition">Cancel</button>
                                    </div>
                                @else
                                    <button wire:click="editRole({{ $user->id }})" class="px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition">Change Role</button>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
