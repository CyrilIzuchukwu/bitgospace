<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\DepositApprovedMail;
use App\Models\DepositTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminDepositController extends Controller
{
    //

    public function allTransactions()
    {
        $transactions = DepositTransaction::with(['user', 'deposit'])
            ->latest()
            ->paginate(20);

        return view('admin.deposits.transactions', compact('transactions'));
    }


    // public function approveDeposit(Request $request, $transactionId)
    // {
    //     try {
    //         $transaction = DepositTransaction::with('deposit')->findOrFail($transactionId);

    //         if (
    //             $transaction->status === 'completed' ||
    //             ($transaction->deposit &&
    //                 ($transaction->deposit->status === 'completed' || $transaction->deposit->approval_status === 'approved'))
    //         ) {
    //             return redirect()->back()->with('info', 'This deposit has already been processed.');
    //         }

    //         DB::transaction(function () use ($transaction) {

    //             // ✅ Update the deposit transaction
    //             $transaction->update(['status' => 'completed']);


    //             // ✅ Update the deposit (if it exists)
    //             if ($transaction->deposit) {
    //                 $transaction->deposit->update([
    //                     'status' => 'completed',
    //                     'approval_status' => 'approved'
    //                 ]);
    //             }

    //             // ✅ Credit the user's wallet
    //             $wallet = Wallet::firstOrCreate(
    //                 ['user_id' => $transaction->user_id],
    //                 ['balance' => 0]
    //             );

    //             $wallet->increment('balance', $transaction->amount);

    //             // ✅ Update the matching reference in the transactions table
    //             Transaction::where('reference', $transaction->reference)->update([
    //                 'status' => 'completed',
    //                 'updated_at' => now()
    //             ]);

    //             // Send approval notification email
    //             $user = $transaction->user;
    //             $data = [
    //                 'name' => $user->name,
    //                 'amount' => $transaction->amount,
    //                 'crypto_amount' => $transaction->crypto_amount,
    //                 'currency' => $transaction->currency,
    //                 'date' => now()->format('M j, Y H:i'),
    //                 'new_balance' => $wallet->balance
    //             ];

    //             Mail::to($user->email)->send(new DepositApprovedMail($data));
    //         });

    //         return redirect()->back()->with('success', 'Deposit approved and funds added to wallet successfully');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', $e->getMessage());
    //     }
    // }

    public function approveDeposit(Request $request, $transactionId)
    {
        try {
            $transaction = DepositTransaction::with('deposit')->findOrFail($transactionId);

            // Check if already processed
            if (
                $transaction->status === 'completed' ||
                ($transaction->deposit &&
                    ($transaction->deposit->status === 'completed' || $transaction->deposit->approval_status === 'approved'))
            ) {
                return redirect()->back()->with('info', 'This deposit has already been processed.');
            }

            // Prepare data for email
            $user = $transaction->user;
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $transaction->user_id],
                ['balance' => 0]
            );

            $data = [
                'name' => $user->name,
                'amount' => $transaction->amount,
                'crypto_amount' => $transaction->crypto_amount,
                'currency' => $transaction->currency,
                'date' => now()->format('M j, Y H:i'),
                'new_balance' => $wallet->balance + $transaction->amount // Projected new balance
            ];

            // First try to send the email
            try {
                Mail::to($user->email)->send(new DepositApprovedMail($data));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send approval email: ' . $e->getMessage());
            }

            // Only proceed with updates if email was sent successfully
            DB::transaction(function () use ($transaction, $wallet) {
                // Update the deposit transaction
                $transaction->update(['status' => 'completed']);

                // Update the deposit (if it exists)
                if ($transaction->deposit) {
                    $transaction->deposit->update([
                        'status' => 'completed',
                        'approval_status' => 'approved'
                    ]);
                }

                // Credit the user's wallet
                $wallet->increment('balance', $transaction->amount);

                // Update the matching reference in the transactions table
                Transaction::where('reference', $transaction->reference)->update([
                    'status' => 'completed',
                    'updated_at' => now()
                ]);
            });

            return redirect()->back()->with('success', 'Deposit approved and funds added to wallet successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to approve deposit: ' . $e->getMessage());
        }
    }



    public function rejectDeposit(Request $request, $transactionId)
    {
        $transaction = DepositTransaction::findOrFail($transactionId);

        $transaction->update(['status' => 'rejected']);

        if ($transaction->deposit) {
            $transaction->deposit->update([
                'status' => 'rejected',
                'approval_status' => 'rejected'
            ]);
        }

        return redirect()->back()->with('success', 'Deposit has been rejected');
    }
}
