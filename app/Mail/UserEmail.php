<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class UserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $email_title;
    public string $email_content;
    public ?string $attachmentFilename;


    /**
     * Create a new message instance.
     */
    public function __construct(string $email_title, string $email_content, ?string $attachmentFilename = null)
    {
        $this->email_title = $email_title;
        $this->email_content = $email_content;
        $this->attachmentFilename = $attachmentFilename;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->email_title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_email',
            with: [
                'email_title' => $this->email_title,
                'email_content' => $this->email_content,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->attachmentFilename) {
            $fullPath = 'attachments/' . $this->attachmentFilename;

            if (Storage::disk('public')->exists($fullPath)) {
                return [
                    Attachment::fromStorageDisk('public', $fullPath)
                ];
            }
        }

        return [];
    }
}
