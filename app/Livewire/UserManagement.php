<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Component
{
    public $editingId = null;
    public $editingRole = '';

    public function mount()
    {
        if (!Auth::user()->isOwner()) {
            abort(403, 'Unauthorized');
        }
    }

    public function editRole($id)
    {
        $user = User::find($id);
        $this->editingId = $id;
        $this->editingRole = $user->role;
    }

    public function updateRole($id)
    {
        if (!Auth::user()->isOwner()) return;

        User::find($id)->update(['role' => $this->editingRole]);
        $this->editingId = null;
        $this->editingRole = '';
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editingRole = '';
    }

    public function render()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('livewire.user-management', compact('users'));
    }
}