<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FarmActivity;
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
            $activity->update([
                'title' => $this->title,
                'type' => $this->type,
                'description' => $this->description,
                'started_at' => $this->started_at ?: null,
                'ended_at' => $this->ended_at ?: null,
                'status' => $this->status,
                'location' => $this->location,
            ]);
        } else {
            FarmActivity::create([
                'title' => $this->title,
                'type' => $this->type,
                'description' => $this->description,
                'started_at' => $this->started_at ?: null,
                'ended_at' => $this->ended_at ?: null,
                'status' => $this->status,
                'location' => $this->location,
                'user_id' => Auth::id(),
            ]);
        }

        $this->reset(['title', 'type', 'description','started_at', 'ended_at', 'status', 'location', 'editingId', 'showForm']);
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
        FarmActivity::find($id)->delete();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->reset(['title', 'type', 'description','started_at', 'ended_at', 'status', 'location', 'editingId']);
        $this->type = 'Planting';
        $this->status = 'Pending';
    }

    public function render()
    {
        $activities = FarmActivity::where('user_id', Auth::id())
            ->orderBy('started_at', 'desc')
            ->get();

        return view('livewire.farm-activities', compact('activities'));
    }
}