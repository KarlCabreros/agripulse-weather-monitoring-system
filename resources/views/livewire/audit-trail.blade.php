<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-green-700 dark:text-green-400">📜 Audit Trail</h1>
        <span class="text-xs text-gray-400">Showing last 50 activities</span>
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Action</th>
                        <th class="px-4 py-3">Record</th>
                        <th class="px-4 py-3">IP Address</th>
                        <th class="px-4 py-3">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="border-b dark:border-neutral-700">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">
                            {{ $log->user->name ?? 'Unknown' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($log->action === 'created')
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">Created</span>
                            @elseif($log->action === 'updated')
                                <span class="px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">Updated</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">Deleted</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $log->model }} #{{ $log->model_id }}</td>
                        <td class="px-4 py-3">{{ $log->ip_address ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $log->created_at->timezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                            📜 No audit logs yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
