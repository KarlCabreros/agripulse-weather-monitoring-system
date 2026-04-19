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
    public $activity_date = '';
    public $status = 'Pending';
    public $location = '';
    public $editingId = null;
    public $showForm = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'type' => 'required|in:Planting,Fertilizing,Irrigation,Harvesting,Pest Control,Other',
        'description' => 'nullable|string',
        'activity_date' => 'required|date',
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
                'activity_date' => $this->activity_date,
                'status' => $this->status,
                'location' => $this->location,
            ]);
        } else {
            FarmActivity::create([
                'title' => $this->title,
                'type' => $this->type,
                'description' => $this->description,
                'activity_date' => $this->activity_date,
                'status' => $this->status,
                'location' => $this->location,
                'user_id' => Auth::id(),
            ]);
        }

        $this->reset(['title', 'type', 'description', 'activity_date', 'status', 'location', 'editingId', 'showForm']);
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
        $this->activity_date = $activity->activity_date->format('Y-m-d');
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
        $this->reset(['title', 'type', 'description', 'activity_date', 'status', 'location', 'editingId']);
        $this->type = 'Planting';
        $this->status = 'Pending';
    }

    public function render()
    {
        $activities = FarmActivity::where('user_id', Auth::id())
            ->orderBy('activity_date', 'desc')
            ->get();

        return view('livewire.farm-activities', compact('activities'));
    }
}