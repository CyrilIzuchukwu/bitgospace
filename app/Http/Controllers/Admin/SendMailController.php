<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Email;
use App\Models\User;
use App\Mail\UserEmail;


class SendMailController extends Controller
{
    // For compose email (all users or single user)
    public function create()
    {
        return view('admin.emails.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email_title' => 'required|string|max:255',
            'email_content' => 'required|string',
            'user_type' => 'required|in:all,single',
            'recipient_email' => 'required_if:user_type,single|nullable|email',
            'attachment' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120', // 5MB max
        ], [
            'email_title.required' => 'Email title is required.',
            'email_content.required' => 'Email content is required.',
            'user_type.required' => 'Please select user type.',
            'recipient_email.required_if' => 'Recipient email is required for single user.',
            'recipient_email.email' => 'Please provide a valid email address.',
            'attachment.mimes' => 'Attachment must be JPG, PNG or PDF format.',
            'attachment.max' => 'Attachment size must not exceed 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            // Handle file upload
            $filename = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('attachments', $filename, 'public');
            }

            // Save email record
            $email = Email::create([
                'email_title' => $validated['email_title'],
                'email_content' => $validated['email_content'],
                'user_type' => $validated['user_type'],
                'recipient_email' => $validated['recipient_email'] ?? null,
                'attachment' => $filename,
                'sent_by' => Auth::user()->id,
                'sent_at' => now(),
            ]);

            // Get recipients
            $recipients = $this->getRecipients(
                $validated['user_type'],
                $validated['recipient_email'] ?? null
            );

            // Send emails
            // foreach ($recipients as $recipient) {
            //     Mail::to($recipient)->send(
            //         new UserEmail(
            //             $validated['email_title'],
            //             $validated['email_content'],
            //             $filename
            //         )
            //     );
            // }

            foreach ($recipients as $recipient) {
                SendUserEmail::dispatch(
                    $recipient,
                    $validated['email_title'],
                    $validated['email_content'],
                    $filename
                );
            }


            $recipientCount = count($recipients);

            return redirect()->route('admin.email.create')
                ->with('success', "Email queued successfully for {$recipientCount} recipient(s). They will be sent within 1-2 minutes.");
        } catch (\Exception $e) {
            // Clean up uploaded file if email sending fails
            if ($filename && Storage::disk('public')->exists('attachments/' . $filename)) {
                Storage::disk('public')->delete('attachments/' . $filename);
            }

            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }



    /**
     * Get recipients based on user type
     */
    protected function getRecipients(string $userType, ?string $recipientEmail)
    {
        if ($userType === 'all') {
            return User::where('role', 'user')->pluck('email')->toArray();
        } else {
            return [$recipientEmail];
        }
    }
}
