<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/**
 * PROCESS EMAIL QUEUE COMMAND
 * 
 * This command processes all queued emails in the background
 * It's designed to be run by a scheduler every minute
 * 
 * HOW IT WORKS:
 * 1. Scheduler calls this command every minute
 * 2. Command runs queue:work to process pending jobs
 * 3. Processes all emails in the 'jobs' table
 * 4. Stops automatically when queue is empty
 * 5. Failed jobs retry up to 3 times
 */
class ProcessEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     * 
     * SIGNATURE EXPLAINED:
     * - 'app:process-email-queue' is the command name
     * - You can run this manually: php artisan app:process-email-queue
     */
    protected $signature = 'app:process-email-queue';

    /**
     * The console command description.
     * 
     * This shows up when you run: php artisan list
     */
    protected $description = 'Process queued emails in the background';

    /**
     * Execute the console command.
     * 
     * This is what actually runs when the command is triggered
     */
    public function handle()
    {
        $this->info('Starting email queue processing...');

        try {
            // Count pending jobs before processing
            $pendingJobs = \DB::table('jobs')->count();

            if ($pendingJobs === 0) {
                $this->info('No emails in queue. Exiting.');
                return Command::SUCCESS;
            }

            $this->info("Found {$pendingJobs} email(s) in queue. Processing...");

            /**
             * RUN QUEUE WORKER
             * 
             * OPTIONS EXPLAINED:
             * --stop-when-empty
             *   - Stops the worker when all jobs are processed
             *   - Prevents the command from running forever
             *   - Perfect for scheduled tasks that run every minute
             * 
             * --tries=3
             *   - If sending an email fails, retry up to 3 times
             *   - Handles temporary issues (network problems, SMTP timeouts)
             *   - After 3 failures, moves job to 'failed_jobs' table
             * 
             * --max-time=3600
             *   - Maximum execution time: 1 hour (3600 seconds)
             *   - Prevents stuck processes from blocking the queue
             *   - If processing takes longer than 1 hour, stop and restart
             * 
             * --sleep=3
             *   - Wait 3 seconds between jobs
             *   - Prevents overwhelming your SMTP server
             *   - Reduces chance of hitting rate limits
             * 
             * --quiet
             *   - Suppresses output (cleaner logs)
             *   - Remove this if you want to see detailed processing logs
             */
            Artisan::call('queue:work', [
                '--stop-when-empty' => true,
                '--tries' => 3,
                '--max-time' => 3600,
                '--sleep' => 3,
                '--quiet' => true,
            ]);

            // Count remaining jobs after processing
            $remainingJobs = \DB::table('jobs')->count();
            $processedCount = $pendingJobs - $remainingJobs;

            $this->info("Processed {$processedCount} email(s). {$remainingJobs} remaining in queue.");

            // Log success for monitoring
            Log::info('Email queue processed', [
                'processed' => $processedCount,
                'remaining' => $remainingJobs,
                'time' => now(),
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            // Log any errors that occur
            $this->error('Error processing email queue: ' . $e->getMessage());

            Log::error('Email queue processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return Command::FAILURE;
        }
    }
}
