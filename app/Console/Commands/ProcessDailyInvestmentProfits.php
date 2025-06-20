<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Investment;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessDailyInvestmentProfits extends Command
{
    protected $signature = 'investments:process-daily-profits';
    protected $description = 'Process daily profits for active investments';

    public function handle()
    {
        $today = Carbon::now();

        Investment::with(['plan', 'user'])
            ->where('status', true)
            ->where('due', 'false')
            ->where('withdrawn', false)
            ->where('end_date', '>=', $today)
            ->chunkById(100, function ($investments) use ($today) {
                foreach ($investments as $investment) {
                    if (!$investment->status || $investment->withdrawn || $today->greaterThan($investment->end_date)) {
                        return;
                    }

                    $dailyProfit = $investment->amount * ($investment->plan->interest_rate / 100);
                    $remainingProfit = $investment->roi - $investment->profit;

                    if ($remainingProfit > 0) {
                        $profitToAdd = min($dailyProfit, $remainingProfit);
                        $investment->increment('profit', $profitToAdd);
                    }

                    // ✅ If investment completed
                    if ($today->greaterThanOrEqualTo($investment->end_date)) {
                        DB::beginTransaction();

                        try {
                            // 1. Mark investment as completed
                            $investment->update([
                                'status' => false, // Mark as inactive (completed)
                                'due'    => true,
                            ]);

                            // 2. Add capital (amount) to user's wallet
                            $wallet = $investment->user->wallet;
                            $wallet->increment('balance', $investment->amount);

                            DB::commit();
                            Log::info("Investment completed, capital returned to wallet. Investment ID: {$investment->id}");
                        } catch (\Throwable $e) {
                            DB::rollBack();
                            Log::error("Error processing completed investment ID {$investment->id}: {$e->getMessage()}");
                        }
                    } else {
                        Log::info("Daily profit added. Investment ID: {$investment->id}");
                    }
                }
            });

        $this->info('Successfully processed daily investment profits.');
    }
}
