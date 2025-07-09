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
    protected $signature = 'app:process-daily-profits';
    protected $description = 'Process daily profits for active investments';

    public function handle()
    {
        $today = Carbon::now();
        $this->info("Starting daily profit processing for {$today->toDateString()}");

        // Process completed investments first
        $this->processCompletedInvestments($today);

        // Then process daily profits for active investments
        $this->processDailyProfits($today);

        $this->info('Successfully processed daily investment profits.');
    }

    private function processCompletedInvestments($today)
    {
        $this->info("Processing completed investments...");

        // Get completed investments without chunking to avoid transaction issues
        $completedInvestments = Investment::with(['plan', 'user'])
            ->where('status', true)
            ->where('due', false) // Use boolean instead of string
            ->where('withdrawn', false)
            ->where('end_date', '<=', $today)
            ->get();

        $this->info("Found {$completedInvestments->count()} completed investments");

        foreach ($completedInvestments as $investment) {
            $this->processCompletedInvestment($investment);
        }
    }

    private function processCompletedInvestment($investment)
    {
        DB::beginTransaction();

        try {
            // Double-check the investment is still eligible (avoid race conditions)
            $freshInvestment = Investment::lockForUpdate()->find($investment->id);

            if (!$freshInvestment || !$freshInvestment->status || $freshInvestment->due || $freshInvestment->withdrawn) {
                DB::rollBack();
                $this->warn("Investment {$investment->id} no longer eligible for completion");
                return;
            }

            // Log current state before update
            $this->info("Before update - Investment {$freshInvestment->id}: status={$freshInvestment->status}, due={$freshInvestment->due}, withdrawn={$freshInvestment->withdrawn}, end_date={$freshInvestment->end_date}");
            Log::info("Processing investment completion - Investment {$freshInvestment->id}: status={$freshInvestment->status}, due={$freshInvestment->due}, end_date={$freshInvestment->end_date}");

            // Mark investment as completed using fresh instance
            $updated = $freshInvestment->update([
                'status' => false,
                'due' => true,
            ]);

            $this->info("Update method returned: " . ($updated ? 'true' : 'false'));

            if (!$updated) {
                throw new \Exception("Failed to update investment status");
            }

            // Check the model's current state (before refresh)
            $this->info("After update (before refresh) - Investment {$freshInvestment->id}: status={$freshInvestment->status}, due={$freshInvestment->due}");

            // Verify the update worked by checking directly in database
            $dbCheck = DB::table('investments')
                ->where('id', $freshInvestment->id)
                ->select('status', 'due', 'withdrawn')
                ->first();

            $this->info("Direct DB check - Investment {$freshInvestment->id}: status={$dbCheck->status}, due={$dbCheck->due}, withdrawn={$dbCheck->withdrawn}");
            Log::info("Database verification - Investment {$freshInvestment->id}: status={$dbCheck->status}, due={$dbCheck->due}");

            // Refresh the model
            $freshInvestment->refresh();
            $this->info("After refresh - Investment {$freshInvestment->id}: status={$freshInvestment->status}, due={$freshInvestment->due}");

            // Check if the values are what we expect
            if ($freshInvestment->due !== true || $freshInvestment->status !== false) {
                $this->error("Expected: status=false, due=true");
                $this->error("Actual: status={$freshInvestment->status}, due={$freshInvestment->due}");
                Log::error("Investment update verification failed - Investment {$freshInvestment->id}: Expected status=false,due=true but got status={$freshInvestment->status},due={$freshInvestment->due}");
                throw new \Exception("Investment update verification failed");
            }

            // Add capital to user's wallet
            $wallet = $freshInvestment->user->wallet;
            $wallet->increment('balance', $freshInvestment->amount);

            // Send completion email
            // Mail::to($freshInvestment->user->email)->send(new InvestmentCompleted($freshInvestment));

            DB::commit();

            $this->info("Investment completed, capital returned to wallet. Investment ID: {$freshInvestment->id}");
            Log::info("Investment completed, capital returned to wallet. Investment ID: {$freshInvestment->id}");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("Error processing completed investment ID {$investment->id}: {$e->getMessage()}");
            Log::error("Error processing completed investment ID {$investment->id}: {$e->getMessage()}");
        }
    }

    private function processDailyProfits($today)
    {
        $this->info("Processing daily profits...");

        $activeInvestmentsCount = Investment::where('status', true)
            ->where('due', false)
            ->where('withdrawn', false)
            ->where('end_date', '>', $today)
            ->count();

        $this->info("Found {$activeInvestmentsCount} active investments for daily profit processing");
        Log::info("Daily profit processing started for {$activeInvestmentsCount} active investments");

        $processedCount = 0;
        $totalProfitAdded = 0;

        // Process daily profits for active investments
        Investment::with(['plan', 'user'])
            ->where('status', true)
            ->where('due', false)
            ->where('withdrawn', false)
            ->where('end_date', '>', $today)
            ->chunkById(100, function ($investments) use ($today, &$processedCount, &$totalProfitAdded) {
                foreach ($investments as $investment) {
                    $profitAdded = $this->processDailyProfit($investment);
                    if ($profitAdded > 0) {
                        $processedCount++;
                        $totalProfitAdded += $profitAdded;
                    }
                }
            });

        $this->info("Daily profit processing completed: {$processedCount} investments processed, total profit added: {$totalProfitAdded}");
        Log::info("Daily profit processing completed: {$processedCount} investments processed, total profit added: {$totalProfitAdded}");
    }

    private function processDailyProfit($investment)
    {
        try {
            $dailyProfit = $investment->amount * ($investment->plan->interest_rate / 100);
            $remainingProfit = $investment->roi - $investment->profit;

            if ($remainingProfit > 0) {
                $profitToAdd = min($dailyProfit, $remainingProfit);
                $investment->increment('profit', $profitToAdd);

                $this->info("Daily profit added - Investment ID: {$investment->id}, Amount: {$profitToAdd}, Remaining: " . ($remainingProfit - $profitToAdd));
                Log::info("Daily profit added - Investment ID: {$investment->id}, Profit: {$profitToAdd}, New total: " . ($investment->profit + $profitToAdd));

                return $profitToAdd;
            }

            return 0;
        } catch (\Throwable $e) {
            $this->error("Error processing daily profit for investment ID {$investment->id}: {$e->getMessage()}");
            Log::error("Error processing daily profit for investment ID {$investment->id}: {$e->getMessage()}");
            return 0;
        }
    }
}
