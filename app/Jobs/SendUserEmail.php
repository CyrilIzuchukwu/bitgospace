<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


use App\Mail\UserEmail;
// use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * SEND USER EMAIL JOB
 *
 * This job handles sending a single email to one recipient
 * It runs in the background via the queue system
 *
 * WHY USE A JOB?
 * - Sends emails in background (user doesn't wait)
 * - Automatically retries if sending fails
 * - Can handle thousands of emails without timeout
 * - Failed emails are tracked in 'failed_jobs' table
 */
class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * RETRY CONFIGURATION
     *
     * $tries = 3
     *   - If sending fails, Laravel will retry 3 times
     *   - Retry delays: immediate, 1 minute, 5 minutes
     *   - Handles temporary issues (SMTP timeout, network glitch)
     *
     * $timeout = 120
     *   - Maximum execution time: 2 minutes (120 seconds)
     *   - If sending takes longer, Laravel kills the job
     *   - Prevents stuck jobs from blocking the queue
     *
     * $backoff = [60, 300]
     *   - First retry: wait 60 seconds
     *   - Second retry: wait 300 seconds (5 minutes)
     *   - Gives SMTP server time to recover if it's having issues
     */
    public $tries = 3;
    public $timeout = 120;
    public $backoff = [60, 300]; // Wait times between retries

    /**
     * PROPERTIES
     *
     * These store the email details
     * They're serialized and saved in the 'jobs' table
     * When the job runs, these values are restored
     */
    protected $recipientEmail;
    protected $emailTitle;
    protected $emailContent;
    protected $attachmentFilenames;

    /**
     * CONSTRUCTOR
     *
     * Called when you dispatch the job:
     * SendUserEmail::dispatch('user@example.com', 'Subject', 'Body', 'file.pdf')
     *
     * Saves all parameters so they can be used later when the job runs
     */
    public function __construct(
        string $recipientEmail,
        string $emailTitle,
        string $emailContent,
        $attachmentFilenames = null

    ) {
        $this->recipientEmail = $recipientEmail;
        $this->emailTitle = $emailTitle;
        $this->emailContent = $emailContent;
        // Ensure it's always an array
        $this->attachmentFilenames = is_array($attachmentFilenames) ? $attachmentFilenames : [];
    }

    /**
     * HANDLE METHOD
     *
     * This is the main method that executes when the queue worker processes this job
     *
     * EXECUTION FLOW:
     * 1. Queue worker picks up job from 'jobs' table
     * 2. Restores job with saved parameters
     * 3. Calls handle() method
     * 4. Sends email via Mail facade
     * 5. If success: deletes job from 'jobs' table
     * 6. If failure: logs error and throws exception (triggers retry)
     */
    public function handle(): void
    {
        try {
            Mail::to($this->recipientEmail)->send(
                new UserEmail(
                    $this->emailTitle,
                    $this->emailContent,
                    $this->attachmentFilenames // Pass array
                )
            );

            Log::info("Email sent successfully", [
                'recipient' => $this->recipientEmail,
                'subject' => $this->emailTitle,
                'attachments_count' => count($this->attachmentFilenames),
                'time' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send email", [
                'recipient' => $this->recipientEmail,
                'subject' => $this->emailTitle,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts(),
            ]);

            throw $e;
        }
    }
    /**
     * FAILED METHOD
     *
     * Called when all retry attempts have been exhausted (after 3 tries)
     * The job is moved from 'jobs' table to 'failed_jobs' table
     *
     * USE CASES:
     * - Log permanent failures for investigation
     * - Send alert to admin about failed emails
     * - Update database to mark email as failed
     * - Trigger alternative notification method (SMS, push notification)
     */
    public function failed(\Throwable $exception): void
    {
        // Log permanent failure with full context
        Log::error("Job permanently failed - email not sent", [
            'recipient' => $this->recipientEmail,
            'subject' => $this->emailTitle,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        // Optional: Notify admin about the failure
        // Mail::to('admin@yoursite.com')->send(new EmailFailedNotification(...));

        // Optional: Update your database to mark email as failed
        // Email::where('recipient_email', $this->recipientEmail)->update(['status' => 'failed']);
    }
}
