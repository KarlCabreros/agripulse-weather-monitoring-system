<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmActivity extends Model

{
    protected $fillable = [
    'title',
    'type',
    'description',
    'started_at',
    'ended_at',
    'status',
    'location',
    'user_id'
];

protected $casts = [
    'started_at' => 'date',
    'ended_at' => 'date',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}