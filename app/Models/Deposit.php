<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    //

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];


    // public function transactions()
    // {
    //     return $this->hasMany(DepositTransaction::class);
    // }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(WalletAddress::class, 'payment_method', 'name');
    }

    public function transactions()
    {
        return $this->hasMany(DepositTransaction::class);
    }
}
