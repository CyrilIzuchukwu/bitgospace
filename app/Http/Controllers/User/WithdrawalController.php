<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletAddress;
use App\Models\Withdrawal;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;
use URL;

class WithdrawalController extends Controller
{
    //

    // public function withdrawal()
    // {

    //     $userId = Auth::id();

    //     $wallet = Wallet::where('user_id', $userId)->first();
    //     // Check if PIN is set
    //     if (!$wallet || !$wallet->pin_set || !$wallet->pin) {
    //         return redirect()->route('user.settings.security')
    //             ->with('warning', 'Please set your transaction PIN before making withdrawals.');
    //     }

    //     $wallets = WalletAddress::all();
    //     return view('user.withdrawals.index', compact('wallets'));
    // }


    // public function setPin()
    // {
    //     return view('user.withdrawals.set-pin');
    // }


    public function setPin(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid URL signature');
        }

        return view('user.withdrawals.set-pin');
    }

    public function withdrawal()
    {
        $userId = Auth::id();
        $wallet = Wallet::where('user_id', $userId)->first();

        if (!$wallet || !$wallet->pin_set || !$wallet->pin) {
            $signedUrl = URL::signedRoute('user.settings.security', [], now()->addMinutes(5));
            return redirect($signedUrl)
                ->with('warning', 'Please set your transaction PIN before making withdrawals.');
        }

        $wallets = WalletAddress::all();
        return view('user.withdrawals.index', compact('wallets'));
    }


    public function createPin(Request $request)
    {
        try {
            $validated = $request->validate([
                'pin' => 'required|digits:4|numeric'
            ]);

            // dd($validated); // For debugging — you can remove later

            $user = Auth::user();
            // dd($user); // For debugging — you can remove later

            $wallet = $user->wallet()->firstOrCreate(['user_id' => $user->id]);

            // Assign and save using save() for reliability
            $wallet->pin = Hash::make($validated['pin']);  // ✅ Hashing PIN before saving
            $wallet->pin_set = true;
            $wallet->save();

            // dd($wallet);

            return redirect()->route('user.withdrawal')->with('success', 'Withdrawal PIN set successfully');
        } catch (\Throwable $e) {
            // dd($e->getMessage()); // For debugging — you can remove after testing
            return back()->with('error', 'An unexpected error occurred.' . $e->getMessage());
        }
    }


    public function initiateWithdrawal(Request $request)
    {

        $user = Auth::user();
        $wallet = $user->wallet()->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'wallet_address' => 'required|string|min:10'
        ]);

        // Check wallet status
        if (!$wallet->status) {
            return back()->with('error', 'Your wallet is currently suspended for withdrawal')->withInput();
        }


        // Check sufficient balance
        if (bccomp($wallet->balance, $request->amount, 2) === -1) {
            return back()->withErrors(['amount' => 'Insufficient balance. Available: $' . number_format($wallet->balance, 2)])->withInput();
        }

        // Check daily withdrawal limit (uncomment to enable)
        // $dailyWithdrawals = Withdrawal::where('user_id', $user->id)
        //     ->whereDate('created_at', today())
        //     ->where('status', '!=', 'rejected')
        //     ->sum('amount');
        //
        // $dailyLimit = 5000; // Set your daily limit
        // if (($dailyWithdrawals + $request->amount) > $dailyLimit) {
        //     $remaining = $dailyLimit - $dailyWithdrawals;
        //     return back()->withErrors([
        //         'amount' => 'Daily withdrawal limit exceeded. You can withdraw up to $'.number_format($remaining, 2).' today'
        //     ])->withInput();
        // }


        // Store withdrawal details in session
        $request->session()->put('pending_withdrawal', [
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'wallet_address' => $request->wallet_address,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(15),
            'wallet_balance' => $wallet->balance // Store current balance for verification
        ]);

        return redirect()->route('user.withdrawal.confirm-pin');
    }


    public function confirmPin(Request $request)
    {
        // Only allow access if there's a pending withdrawal
        if (!$request->session()->has('pending_withdrawal')) {
            return redirect()->route('user.withdrawal')->with('error', 'No pending withdrawal to confirm');
        }

        return view('user.withdrawals.confirm-pin');
    }


    public function confirmWithdrawal(Request $request)
    {
        try {
            // Validate PIN
            $request->validate(['full_pin' => 'required|digits:4']);


            // Get pending withdrawal from session
            $withdrawalData = $request->session()->get('pending_withdrawal');
            if (!$withdrawalData) {
                return redirect()->route('user.withdrawal')->with('error', 'Withdrawal session expired');
            }



            if (Carbon::parse($withdrawalData['expires_at'])->isPast()) {
                $request->session()->forget('pending_withdrawal');
                return redirect()->route('user.withdrawal')
                    ->with('error', 'Withdrawal session expired. Please try again.');
            }

            $user = Auth::user();
            $wallet = $user->wallet;

            // dd($user);

            // Verify PIN
            if (!Hash::check($request->full_pin, $wallet->pin)) {
                // return back()->withErrors(['pin' => 'Invalid PIN'])->withInput();
                return redirect()->back()->with('error', 'Invalid PIN');
                // dd('there is an error');
            }




            // we are here

            DB::transaction(function () use ($user, $wallet, $withdrawalData) {
                // Create withdrawal record

                $reference = 'WDR-' . strtoupper(substr($withdrawalData['payment_method'], 0, 3)) . '-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(5));

                $withdrawal = Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $withdrawalData['amount'],
                    'payment_method' => $withdrawalData['payment_method'],
                    'wallet_address' => $withdrawalData['wallet_address'],
                    'status' => 'pending',
                    'reference' => $reference,
                ]);

                // Deduct from wallet balance
                // $wallet->decrement('balance', $withdrawalData['amount']);

                // Create transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $withdrawalData['amount'],
                    'type' => 'withdrawal',
                    'status' => 'pending',
                    'description' => 'Withdrawal request via ' . strtoupper($withdrawalData['payment_method']),
                    'reference' => $reference
                ]);
            });

            // Clear session
            $request->session()->forget('pending_withdrawal');

            return redirect()->route('user.withdrawal.history')->with('success', 'Withdrawal request submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd('Error: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function withdrawalHistory()
    {
        $withdrawals = Withdrawal::where('user_id', Auth::id())
            ->latest()
            ->paginate(15);
        return view('user.withdrawals.withdrawal-list', compact('withdrawals'));
    }
}
