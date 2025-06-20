<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralCommission extends Model
{
    //
    protected $guarded = [];

    // Relationship to the user who was referred (made the investment)
    public function investor()
    {
        return $this->belongsTo(User::class, 'investor_id');
    }


    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Relationship to the referrer (who earns the commission)
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    // Relationship to the investment
    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }
}
