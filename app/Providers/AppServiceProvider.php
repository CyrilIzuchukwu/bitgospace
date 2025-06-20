<?php

namespace App\Providers;

use App\Models\DepositTransaction;
use App\Models\Investment;
use App\Models\KycVerification;
use App\Models\ReferralCommission;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Services\CryptoConverter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->app->bind(CryptoConverter::class, function ($app) {
            return new CryptoConverter();
        });

        View::composer('*', function ($view) {

            if (Auth::check()) {
                $user = Auth::user()->load('profile');
                $view->with('user', $user);
            }

            $balance = null;
            $balanceVisible = true;
            $totalDeposits = null;
            $totalInvestments = null;
            $runningInvestments = null;
            $totalWithdrawals = null;
            $userKyc = null;
            $totalReferralBonus = null;
            $successfulWithdrawalsCount = 0;
            $pendingWithdrawalsCount = 0;

            $level1Commissions = 0; // Initialize level counters
            $level2Commissions = 0;
            $level3Commissions = 0;


            if (Auth::check()) {
                $wallet = Wallet::where('user_id', Auth::id())->first();
                $balance = $wallet ? number_format($wallet->balance, 2) : '0.00';

                // Calculate total completed deposits
                $totalDeposits = DepositTransaction::where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->sum('amount');
                $totalDeposits = number_format($totalDeposits, 2);


                // Investments
                $totalInvestments = Investment::where('user_id', Auth::id())
                    ->sum('amount');

                $runningInvestments = Investment::where('user_id', Auth::id())
                    ->where('due', false) // Only active investments
                    ->sum('amount');

                $totalWithdrawals = Withdrawal::where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->sum('amount');
                $totalWithdrawals = number_format($totalWithdrawals, 2);


                // Withdrawal counts
                $successfulWithdrawalsCount = Withdrawal::where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->count();

                $pendingWithdrawalsCount = Withdrawal::where('user_id', Auth::id())
                    ->where('status', 'pending')
                    ->count();



                // Get KYC verification
                $userKyc = KycVerification::where('user_id', Auth::id())
                    ->latest()
                    ->first();


                // Calculate referral bonuses by level
                $referralCommissions = ReferralCommission::where('referrer_id', Auth::id())
                    ->selectRaw('level, SUM(amount) as total')
                    ->groupBy('level')
                    ->get();

                foreach ($referralCommissions as $commission) {
                    switch ($commission->level) {
                        case 1:
                            $level1Commissions = $commission->total;
                            break;
                        case 2:
                            $level2Commissions = $commission->total;
                            break;
                        case 3:
                            $level3Commissions = $commission->total;
                            break;
                    }
                }

                $totalReferralBonus = $level1Commissions + $level2Commissions + $level3Commissions;
                $totalReferralBonus = number_format($totalReferralBonus, 2);
                $level1Commissions = number_format($level1Commissions, 2);
                $level2Commissions = number_format($level2Commissions, 2);
                $level3Commissions = number_format($level3Commissions, 2);



                // Calculate total referral bonus
                $totalReferralBonus = ReferralCommission::where('referrer_id', Auth::id())
                    ->sum('amount');
                $totalReferralBonus = number_format($totalReferralBonus, 2);



                // Get visibility state from session (if you want to persist it)
                $balanceVisible = session()->get('balance_visible', true);
            }

            $view->with([
                'walletBalance' => $balance,
                'totalDeposits' => $totalDeposits,
                'totalWithdrawals' => $totalWithdrawals,
                'totalInvestments' => number_format($totalInvestments ?? 0, 2),
                'runningInvestments' => number_format($runningInvestments ?? 0, 2),
                'balanceVisible' => $balanceVisible,
                'userKyc' => $userKyc,
                'totalReferralBonus' => $totalReferralBonus ?? '0.00',
                'successfulWithdrawalsCount' => $successfulWithdrawalsCount,
                'pendingWithdrawalsCount' => $pendingWithdrawalsCount,

                'level1Commissions' => $level1Commissions ?? '0.00',
                'level2Commissions' => $level2Commissions ?? '0.00',
                'level3Commissions' => $level3Commissions ?? '0.00'
            ]);
        });
    }
}
