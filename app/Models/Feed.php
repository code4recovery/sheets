<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Feed extends Model
{
    use HasFactory;

    protected $casts = [
        'refreshed_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function canEdit()
    {
        return $this->belongsToMany(User::class)->where('user_id', '=', Auth::id());
    }
}
