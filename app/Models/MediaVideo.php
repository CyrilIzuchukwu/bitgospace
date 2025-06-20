<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaVideo extends Model
{
    protected $fillable = [
        'title',
        'language',
        'video_path',
        'reference_id',
        'description'
    ];
}
