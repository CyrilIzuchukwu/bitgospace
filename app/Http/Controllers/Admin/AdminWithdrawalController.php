<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WithdrawalApproved;
use App\Models\Transaction;
use App\Models\Withdrawal;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminWithdrawalController extends Controller
{
    //

    public function allWithdrawals()
    {
        $withdrawals = Withdrawal::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }


    public function approveWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $user = $withdrawal->user;

        // First try to send the email
        try {
            Mail::to($user->email)->send(new WithdrawalApproved($withdrawal));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send approval email: ' . $e->getMessage());
        }

        // Only proceed with updates if email was sent successfully
        try {
            DB::transaction(function () use ($withdrawal, $user) {
                $withdrawal->update([
                    'status' => 'completed',
                    'updated_at' => now()
                ]);

                Transaction::where('reference', $withdrawal->reference)
                    ->update([
                        'status' => 'completed',
                        'updated_at' => now()
                    ]);

                $user->wallet->decrement('balance', $withdrawal->amount);
            });

            return back()->with('success', 'Withdrawal approved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    public function rejectWithdrawal(Request $request, $id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update(['status' => 'rejected']);

            Transaction::where('reference', $withdrawal->reference)
                ->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Withdrawal rejected successfully');
    }
}
