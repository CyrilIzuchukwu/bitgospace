<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


/**
 * ============================================
 * NEW: EMAIL QUEUE PROCESSING
 * ============================================
 * 
 * This processes queued emails every minute
 * 
 * SCHEDULE OPTIONS EXPLAINED:
 * 
 * everyMinute()
 *   - Runs this command every 60 seconds
 *   - Ensures emails are sent quickly after being queued
 *   - You can change this to everyTwoMinutes(), everyFiveMinutes(), etc.
 * 
 * withoutOverlapping()
 *   - Prevents multiple instances from running at the same time
 *   - If the previous run is still processing, skip this run
 *   - Critical for preventing duplicate email sends
 *   - Uses a lock file to track if command is running
 * 
 * runInBackground()
 *   - Runs the command in the background
 *   - Doesn't block other scheduled tasks from running
 *   - Your other cron jobs (CheckExpiredDeposits, etc.) run independently
 */

Schedule::command('app:process-email-queue')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

/**
 * ============================================
 * OPTIONAL: QUEUE MAINTENANCE
 * ============================================
 * 
 * Clean up old failed jobs to keep database tidy
 * Deletes failed jobs older than 7 days (168 hours)
 */
Schedule::command('queue:prune-failed --hours=168')
    ->daily()
    ->runInBackground();
