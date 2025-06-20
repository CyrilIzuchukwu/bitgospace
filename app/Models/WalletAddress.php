<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletAddress extends Model
{
    //

    protected $fillable = ['name', 'slug', 'address', 'symbol', 'qr_code'];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
