<?php

namespace App\Notifications;

use App\Models\KycVerification;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewKycSubmission extends Notification implements ShouldQueue
{
    use Queueable;

    public $kycVerification;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(KycVerification $kycVerification, User $user)
    {
        $this->kycVerification = $kycVerification;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {


        $viewPath = resource_path('views/emails/kyc/new_submission.blade.php');
        \Log::info('Checking email view at: ' . $viewPath);

        if (!file_exists($viewPath)) {
            \Log::error('Email view not found at: ' . $viewPath);
        }

        
        // return (new MailMessage)
        //     ->subject("New KYC Submission Received {$this->user->name}")
        //     ->line('A new KYC verification request has been submitted.')
        //     ->line('User: ' . $this->user->name)
        //     ->line('Email: ' . $this->user->email)
        //     ->line('Document Type: ' . $this->kycVerification->document_type)
        //     ->line('Country: ' . $this->kycVerification->country)
        //     ->action('Review Submission', route('admin.kyc.show', $this->kycVerification->id));


        return (new MailMessage)
            ->subject("New KYC Submission from {$this->user->name}")
            ->markdown('emails.kyc.new_submission', [
                'user' => $this->user,
                'kyc' => $this->kycVerification,
                'url' => route('admin.kyc.show', $this->kycVerification->id)
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
