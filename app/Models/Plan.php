<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $guarded = [];


    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'duration' => 'integer',
    ];
}
