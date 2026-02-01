<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbassadorReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'required_referrals',
        'reward_type',
        'cash_amount',
        'description',
        'status',
    ];

    protected $casts = [
        'cash_amount' => 'decimal:2',
        'required_referrals' => 'integer',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
