<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //

    public function transactions(Request $request)
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('user.transactions.index', compact('transactions'));
    }
}
