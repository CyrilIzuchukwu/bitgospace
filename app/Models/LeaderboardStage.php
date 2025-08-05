<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardStage extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'target_amount',
        'status',
        'order'
    ];

    public function userProgress()
    {
        return $this->hasMany(LeaderboardUserProgress::class, 'stage_id');
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
