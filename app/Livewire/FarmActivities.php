<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FarmActivity;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class FarmActivities extends Component
{
    public $title = '';
    public $type = 'Planting';
    public $description = '';
    public $started_at = '';
    public $ended_at = '';
    public $status = 'Pending';
    public $location = '';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'type' => 'required|in:Planting,Fertilizing,Irrigation,Harvesting,Pest Control,Other',
        'description' => 'nullable|string',
        'started_at' => 'nullable|date',
        'ended_at' => 'nullable|date',
        'status' => 'required|in:Pending,In Progress,Completed',
        'location' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            $activity = FarmActivity::find($this->editingId);
            $oldValues = $activity->toArray();

            $activity->update([
                'title' => $this->title,
                'type' => $this->type,
                'description' => $this->description,
                'started_at' => $this->started_at ?: null,
                'ended_at' => $this->ended_at ?: null,
                'status' => $this->status,
                'location' => $this->location,
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'updated',
                'model' => 'FarmActivity',
                'model_id' => $activity->id,
                'old_values' => $oldValues,
                'new_values' => $activity->fresh()->toArray(),
                'ip_address' => request()->ip(),
            ]);

        } else {
            $activity = FarmActivity::create([
                'title' => $this->title,
                'type' => $this->type,
                'description' => $this->description,
                'started_at' => $this->started_at ?: null,
                'ended_at' => $this->ended_at ?: null,
                'status' => $this->status,
                'location' => $this->location,
                'user_id' => Auth::id(),
            ]);

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'created',
                'model' => 'FarmActivity',
                'model_id' => $activity->id,
                'new_values' => $activity->toArray(),
                'ip_address' => request()->ip(),
            ]);
        }

        $this->reset(['title', 'type', 'description', 'started_at', 'ended_at', 'status', 'location', 'editingId', 'showForm']);
        $this->type = 'Planting';
        $this->status = 'Pending';
    }

    public function edit($id)
    {
        $activity = FarmActivity::find($id);
        $this->editingId = $activity->id;
        $this->title = $activity->title;
        $this->type = $activity->type;
        $this->description = $activity->description;
        $this->started_at = $activity->started_at ? $activity->started_at->format('Y-m-d') : '';
        $this->ended_at = $activity->ended_at ? $activity->ended_at->format('Y-m-d') : '';
        $this->status = $activity->status;
        $this->location = $activity->location;
        $this->showForm = true;
    }

    public function delete($id)
    {
        $activity = FarmActivity::find($id);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'model' => 'FarmActivity',
            'model_id' => $id,
            'old_values' => $activity->toArray(),
            'ip_address' => request()->ip(),
        ]);

        $activity->delete();
    }

    public function toggleForm()
    {
        if (!Auth::user()->canManageActivities()) {
            return;
        }
        $this->showForm = !$this->showForm;
        $this->reset(['title', 'type', 'description', 'started_at', 'ended_at', 'status', 'location', 'editingId']);
        $this->type = 'Planting';
        $this->status = 'Pending';
    }

    public function render()
{
    if (Auth::user()->isOwner()) {
        // Owner sees ALL activities from everyone
        $activities = FarmActivity::with('user')
            ->orderByDesc('started_at')
            ->orderByDesc('created_at')
            ->get();
    } else {
        // Manager/Worker sees only their own
        $activities = FarmActivity::where('user_id', Auth::id())
            ->orderByDesc('started_at')
            ->orderByDesc('created_at')
            ->get();
    }

    return view('livewire.farm-activities', compact('activities'));
}
}
