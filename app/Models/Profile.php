<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'country',
        'state',
        'city',
        'address',
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
