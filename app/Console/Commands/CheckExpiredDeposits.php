<?php

namespace App\Console\Commands;

use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredDeposits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-deposits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for and mark expired deposits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $this->info("Checking for deposits expired as of {$now->format('Y-m-d H:i:s')}");

        // Get deposits that are initiated and past their expiration time
        $expiredDeposits = Deposit::where('status', 'initiated')
            ->where('expires_at', '<=', $now)
            ->get();

        $count = $expiredDeposits->count();

        if ($count === 0) {
            $this->info('No expired deposits found.');
            return;
        }

        // Update each expired deposit
        foreach ($expiredDeposits as $deposit) {
            $deposit->update([
                'status' => 'expired',
                'expired_at' => $now // Optional: record when it was marked expired
            ]);

            $this->line("Marked deposit #{$deposit->id} as expired (user: {$deposit->user_id}, amount: {$deposit->amount})");
        }

        // Log the results
        Log::info("Marked {$count} deposits as expired", [
            'time' => $now,
            'deposit_ids' => $expiredDeposits->pluck('id')->toArray()
        ]);

        $this->info("Successfully marked {$count} deposits as expired.");
    }
}
