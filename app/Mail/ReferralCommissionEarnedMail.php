<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferralCommissionEarnedMail extends Mailable
{
    use Queueable, SerializesModels;


    public $referrer;
    public $investor;
    public $commission;
    public $level;
    /**
     * Create a new message instance.
     */
    public function __construct(User $referrer, User $investor, $commission, $level)
    {
        $this->referrer = $referrer;
        $this->investor = $investor;
        $this->commission = $commission;
        $this->level = $level;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You Earned a Referral Commission!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.referral_commission_earned',
            with: [
                'referrerName' => $this->referrer->name,
                'investorName' => $this->investor->name,
                'commission' => $this->commission,
                'level' => $this->level
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
