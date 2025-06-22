<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawalWalletAddress extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'address',
        'symbol',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
