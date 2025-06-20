<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function adminDashboard()
    {
        return view('admin.index');
    }

    // public function userList()
    // {
    //     return view('admin.users');
    // }


    public function userList()
    {
        $users = User::with(['wallet'])
            ->where('role', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    // public function banUser(User $user)
    // {
    //     $user->active = 0;
    //     $user->save();

    //     // dd($user);
    //     return back()->with('success', 'User has been banned');
    // }

    public function banUser(User $user)
    {
        DB::transaction(function () use ($user) {
            // Ban the user
            $user->active = 0;
            $user->save();

            // Invalidate all active sessions
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        });

        // If banning the current user, log them out immediately
        if (Auth::id() === $user->id) {
            Auth::logout();
        }

        return back()->with('success', 'User has been banned and logged out from all devices');
    }

    public function unbanUser(User $user)
    {
        $user->update(['active' => 1]);
        return back()->with('success', 'User has been unbanned');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User has been deleted');
    }


    public function show($id)
    {
        $viewedUser = User::with('wallet', 'transactions')->findOrFail($id);
        // dd($viewedUser);

        $balance = $viewedUser->wallet ? $viewedUser->wallet->balance : 0;
        // dd($balance);

        $transactions = $viewedUser->transactions()->latest()->paginate(10);
        // dd($transactions);

        return view('admin.users.show', [
            'viewedUser' => $viewedUser,
            'balance' => $balance,
            'walletStatus' => $viewedUser->wallet ? $viewedUser->wallet->status : false,
            'transactions' => $transactions
        ]);
    }




    public function fundWallet(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:1000000',
        ]);

        DB::beginTransaction();
        try {
            // Create wallet if it doesn't exist
            $wallet = $user->wallet()->firstOrCreate(
                ['user_id' => $user->id],
                ['status' => true]
            );

            // dd('lets check something');
            $wallet->increment('balance', $request->amount);


            DB::commit();

            return redirect()->back()->with('success', 'Wallet funded successfully. New Balance: $' . number_format($wallet->fresh()->balance, 2));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to fund wallet: ' . $e->getMessage());
        }
    }

    public function deductWallet(Request $request, User $user)
    {
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user->wallet || $value > $user->wallet->balance) {
                        $fail('Amount exceeds available balance');
                    }
                }
            ],
        ]);

        DB::beginTransaction();
        try {
            $wallet = $user->wallet;
            $wallet->decrement('balance', $request->amount);



            DB::commit();

            return redirect()->back()->with(
                'success',
                'Funds deducted successfully. New Balance: $' . number_format($wallet->fresh()->balance, 2)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to deduct funds: ' . $e->getMessage());
        }
    }


    public function activateWallet($id)
    {
        try {
            $user = User::with('wallet')->findOrFail($id);

            // Debug to confirm you're getting the right user and wallet
            // dd([
            //     'user' => $user,
            //     'wallet' => $user->wallet
            // ]);

            if (!$user->wallet) {
                return back()->with('error', 'User does not have a wallet to activate.');
            }

            DB::transaction(function () use ($user) {
                $user->wallet->update(['status' => true]);
            });

            return back()->with('success', 'Wallet has been activated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Activation failed: ' . $e->getMessage());
        }
    }


    public function deactivateWallet($id)
    {
        try {
            $user = User::with('wallet')->findOrFail($id);

            if (!$user->wallet) {
                return back()->with('error', 'User does not have a wallet to deactivate.');
            }

            DB::beginTransaction();

            $user->wallet->status = false;
            $saved = $user->wallet->save();

            DB::commit();

            if ($saved) {
                return back()->with('success', 'Wallet has been deactivated successfully.');
            } else {
                return back()->with('error', 'Failed to update wallet status.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Deactivation failed: ' . $e->getMessage());
        }
    }
}
