<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\DepositNotificationMail;
use App\Models\Deposit;
use App\Models\DepositTransaction;
use App\Models\Transaction;
use App\Models\WalletAddress;
use App\Services\CryptoConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Str;

class DepositController extends Controller
{
    //
    public function deposit()
    {
        // Check if session has deposit_id
        if (session()->has('deposit_id')) {
            $depositId = session('deposit_id');
            $deposit = Deposit::find($depositId);

            // Extra check: Make sure the deposit exists and is still initiated
            if ($deposit && $deposit->status === 'initiated') {
                // Check if deposit hasn't expired
                if ($deposit->expires_at && $deposit->expires_at->isFuture()) {
                    return redirect()->route('confirm.deposit');
                } else {
                    // If expired, clean up the session and deposit
                    session()->forget('deposit_id');
                    if ($deposit) {
                        $deposit->update(['status' => 'expired']);
                    }
                }
            } else {
                // If the deposit doesn't exist or has been completed, forget session
                session()->forget('deposit_id');

                // ADD THIS LINE to break the loop
                return redirect()->route('user.deposit')->with('error', 'Your previous deposit was not found or completed. Please initiate a new deposit.');
            }
        }

        // If no valid session deposit, show deposit form
        $wallets = WalletAddress::all();
        return view('user.deposits.index', compact('wallets'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        // Check if user already has an active deposit session
        if (session()->has('deposit_id')) {
            $existingDepositId = session('deposit_id');
            $existingDeposit = Deposit::find($existingDepositId);

            // If there's still an active deposit, redirect to wallet
            if (
                $existingDeposit && $existingDeposit->status === 'initiated' &&
                $existingDeposit->expires_at && $existingDeposit->expires_at->isFuture()
            ) {
                return redirect()->route('confirm.deposit');
            } else {
                // Clean up expired or invalid session
                session()->forget('deposit_id');
                if ($existingDeposit && $existingDeposit->status === 'initiated') {
                    $existingDeposit->update(['status' => 'expired']);
                }
            }
        }

        $deposit = Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'initiated',
            'expires_at' => Carbon::now()->addHour(),
            // 'expires_at' => now()->addSeconds(90),
        ]);

        // Save to session
        session(['deposit_id' => $deposit->id]);

        return redirect()->route('confirm.deposit');
    }


    public function showWallet()
    {
        $depositId = session('deposit_id');

        if (!$depositId) {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'Deposit not found. Please initiate a new deposit.');
            // return redirect()->route('user.deposit')->with('error', 'No active deposit session found.');
        }

        $deposit = Deposit::find($depositId);

        if (!$deposit) {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'Deposit not found.');
        }

        // Check if deposit is still valid
        if ($deposit->status !== 'initiated') {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'This deposit is no longer active.');
        }

        // Check if deposit has expired
        if ($deposit->expires_at && $deposit->expires_at->isPast()) {
            $deposit->update(['status' => 'expired']);
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'This deposit has expired. Please create a new one.');
        }

        // Get wallet address using the saved payment method (wallet name)
        $wallet = WalletAddress::where('name', $deposit->payment_method)->first();

        if (!$wallet) {
            return redirect()->route('user.deposit')->with('error', 'Wallet not found for the selected payment method.');
        }

        // Calculate crypto amount based on current rate
        $converter = new CryptoConverter();
        $cryptoAmount = $converter->convertToCrypto($deposit->amount, $wallet->symbol);

        return view('user.deposits.wallet', compact('deposit', 'wallet', 'cryptoAmount'));
    }

    public function cancel(Request $request)
    {
        $depositId = session('deposit_id');

        if (!$depositId) {
            return redirect()->route('user.deposit')->with('error', 'No active deposit to cancel.');
        }

        $deposit = Deposit::find($depositId);

        if (!$deposit) {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'Deposit not found.');
        }

        if ($deposit->status !== 'initiated') {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'This deposit cannot be cancelled.');
        }

        // Update status and delete
        $deposit->delete(); // or forceDelete() if you want permanent deletion

        session()->forget('deposit_id');

        return response()->json([
            'success' => true,
            'redirect' => route('user.deposit'),
            'message' => 'Your deposit has been successfully cancelled. You can initiate a new deposit anytime.'
        ]);
    }


    public function processDeposit(Request $request)
    {
        // Validate the request
        $request->validate([
            'deposit_id' => 'required|numeric',
            'balance' => 'required|numeric|min:0.00000001', // Minimum crypto amount
            'amount' => 'required|numeric',
            'transaction_hash' => 'required|string|max:255'
        ]);

        // Get the deposit from session and database
        $depositId = session('deposit_id');
        if (!$depositId || $depositId != $request->deposit_id) {
            return redirect()->route('user.deposit')->with('error', 'Invalid deposit session.');
        }

        $deposit = Deposit::find($depositId);
        if (!$deposit) {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'Deposit not found.');
        }

        // Verify deposit status and expiration
        if ($deposit->status !== 'initiated') {
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'This deposit is no longer active.');
        }

        if ($deposit->expires_at && $deposit->expires_at->isPast()) {
            $deposit->update(['status' => 'expired']);
            session()->forget('deposit_id');
            return redirect()->route('user.deposit')->with('error', 'This deposit has expired.');
        }

        // Get the wallet
        $wallet = WalletAddress::where('name', $deposit->payment_method)->first();
        if (!$wallet) {
            return redirect()->route('user.deposit')->with('error', 'Wallet not found.');
        }

        // dd($wallet);

        $user = Auth::user();
        $kycAdminEmail = env('KYC_ADMIN_EMAIL', 'hello@bitgospace.com');

        $reference = 'DEP-' . strtoupper($wallet->symbol) . '-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(5));

        // Prepare data for the email
        // Prepare data for the email
        $data = [
            'user' => $user,
            'deposit' => [
                'amount' => $request->amount,
                'crypto_amount' => $request->balance,
                'currency' => $wallet->symbol,
                'payment_method' => $wallet->name,
                'transaction_hash' => $request->input('transaction_hash'),
                'reference' => $reference,
            ],
            'time' => now()->toDateTimeString(),
        ];

        // Send email to admin FIRST
        try {
            Mail::to($kycAdminEmail)->send(new DepositNotificationMail($data));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send deposit notification email: ' . $e->getMessage());
        }

        // Process the deposit (in a transaction for safety)
        try {
            DB::beginTransaction();

            // Update deposit status
            $deposit->update([
                'status' => 'pending',
                'amount' => $request->amount,
                // 'wallet_address' => $wallet->address,
                'expires_at' => null,
                'transaction_hash' => $request->input('transaction_hash'),

            ]);


            // Create a transaction record
            $transaction = DepositTransaction::create([
                'user_id' => Auth::id(),
                'deposit_id' => $deposit->id,
                'amount' => $deposit->amount,
                'crypto_amount' => $request->balance,
                'currency' => $wallet->symbol,
                'transaction_hash' => $deposit->transaction_hash,
                'type' => 'deposit',
                'status' => 'pending',
                'description' => 'Deposit initiated',
                'reference' => $reference,
            ]);

            // ✅ Create main transaction record for tracking deposits uniformly
            Transaction::create([
                'user_id' => Auth::id(),
                'amount' => $deposit->amount,
                'type' => 'deposit',
                'status' => 'pending',
                'description' => 'Deposit via ' . $wallet->name,
                'reference' => $reference
            ]);

            // Optionally: Notify admin or trigger payment verification
            // $this->notifyAdmin($deposit);

            DB::commit();

            // Clear the session
            session()->forget('deposit_id');

            // Redirect to success page
            return redirect()->route('deposit.success')->with([
                'success' => 'Deposit submitted successfully!',
                'deposit' => $deposit,
                'transaction' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Deposit processing failed: ' . $e->getMessage());
            // dd('Deposit processing failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Deposit processing failed: ' . $e->getMessage());
        }
    }


    public function depositSuccess()
    {
        if (!session()->has('success')) {
            return redirect()->route('user.deposit');
        }

        return view('user.deposits.success', [
            'deposit' => session('deposit'),
            'transaction' => session('transaction')
        ]);
    }


    public function depositList()
    {
        $transactions = DepositTransaction::with(['user', 'deposit'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('user.deposits.deposit-list', compact('transactions'));
    }


    public function cancelDeposit($id)
    {
        // Find the transaction with its related deposit
        $transaction = DepositTransaction::with('deposit')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        // Validation checks
        if (!$transaction) {
            return redirect()->route('user.deposit.list')->with('error', 'Transaction not found.');
        }

        if ($transaction->status !== 'pending') {
            return redirect()->route('user.deposit.list')->with('error', 'Only pending transactions can be canceled.');
        }

        if (!$transaction->deposit) {
            return redirect()->route('user.deposit.list')->with('error', 'Associated deposit not found.');
        }

        // Perform the cancellation in a transaction for safety
        try {
            DB::beginTransaction();

            // Delete the transaction
            $transaction->delete();

            // Delete the associated deposit
            $transaction->deposit->delete();

            DB::commit();

            return redirect()->route('user.deposit-list')->with('success', 'Deposit canceled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Deposit cancellation failed: ' . $e->getMessage());

            return redirect()->route('user.deposit-list')->with('error', $e->getMessage());
        }
    }
}
