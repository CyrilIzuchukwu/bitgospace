<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function userDashboard()
    {
        session()->forget(['kyc_token', 'kyc_token_created_at', 'kyc_step', 'kyc_data']);
        return view('user.index');
    }

    public function transactions()
    {
        $transactions = Transaction::latest()->paginate(15);
        return view('admin.transactions', compact('transactions'));
    }
}
