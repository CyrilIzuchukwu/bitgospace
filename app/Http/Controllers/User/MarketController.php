<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    //


    public function overview()
    {
        return view('user.markets.overview');
    }

    public function livePrice()
    {
        return view('user.markets.live-price');
    }
}
