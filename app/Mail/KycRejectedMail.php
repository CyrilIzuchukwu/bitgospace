<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KycRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userToNotify;
    public $rejectionReason;

    /**
     * Create a new message instance.
     */
    public function __construct($userToNotify, $rejectionReason)
    {
        $this->userToNotify = $userToNotify;
        $this->rejectionReason = $rejectionReason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your KYC has been rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.kyc.kyc_rejected',
            with: [
                'user' => $this->userToNotify,
                'rejectionReason' => $this->rejectionReason,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
