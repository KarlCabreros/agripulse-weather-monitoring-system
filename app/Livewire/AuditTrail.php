<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditTrail extends Component
{
    public function mount()
    {
        if (!Auth::user()->isOwner()) {
            abort(403, 'Unauthorized');
        }
    }

    public function render()
    {
        $logs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return view('livewire.audit-trail', compact('logs'));
    }
}