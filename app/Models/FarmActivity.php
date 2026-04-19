<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmActivity extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'activity_date',
        'status',
        'location',
        'user_id'
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}