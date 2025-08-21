<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MailjetApiService
{
    protected $apiKey;
    protected $secretKey;
    protected $version;

    public function __construct()
    {
        $this->apiKey = config('services.mailjet.key');
        $this->secretKey = config('services.mailjet.secret');
        $this->version = config('services.mailjet.version', 'v3.1');
    }

    public function sendBulkEmail(array $recipients, string $subject, string $htmlContent, array $attachments = [])
    {
        $endpoint = "https://api.mailjet.com/{$this->version}/send";

        // Prepare attachments for Mailjet
        $mailjetAttachments = array_map(function ($file) {
            return [
                'ContentType' => $file->getClientMimeType(),
                'Filename' => $file->getClientOriginalName(),
                'Base64Content' => base64_encode(file_get_contents($file->getRealPath()))
            ];
        }, $attachments);

        $payload = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => config('mail.from.address'),
                        'Name' => config('mail.from.name'),
                    ],
                    'To' => $recipients,
                    'Subject' => $subject,
                    'HTMLPart' => $htmlContent,
                    'Attachments' => $mailjetAttachments,
                ]
            ]
        ];

        $response = Http::withBasicAuth($this->apiKey, $this->secretKey)
            ->post($endpoint, $payload);

        return $response->successful();
    }
}
