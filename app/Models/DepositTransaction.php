<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositTransaction extends Model
{
    //
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

}
