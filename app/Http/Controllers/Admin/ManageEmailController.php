<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Email;
use App\Models\User;
use App\Mail\UserEmail;

class ManageEmailController extends Controller
{
    public function emailForm($id)
    {
        $userEmail = User::findOrFail($id);
        return view('admin.users.email', compact('userEmail'));
    }

    public function sendEmail(Request $request, $id)
    {
        $recipient = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'email_title' => 'required|string|max:255',
            'email_content' => 'required|string',
            'attachments' => 'nullable|array|max:5', // Max 5 files
            'attachments.*' => 'file|mimes:jpeg,jpg,png,pdf|max:5120', // 5MB per file
        ], [
            'email_title.required' => 'Email title is required.',
            'email_content.required' => 'Email content is required.',
            'attachments.max' => 'You can upload a maximum of 5 files.',
            'attachments.*.mimes' => 'Attachments must be JPG, PNG or PDF format.',
            'attachments.*.max' => 'Each attachment must not exceed 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        try {
            // Handle multiple file uploads
            $filenames = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('attachments', $filename, 'public');
                    $filenames[] = $filename;
                }
            }

            // Save email record
            $email = Email::create([
                'email_title' => $validated['email_title'],
                'email_content' => $validated['email_content'],
                'user_type' => 'single',
                'recipient_email' => $recipient->email,
                'attachments' => $filenames, // Store as JSON array
                'sent_by' => Auth::user()->id,
                'sent_at' => now(),
            ]);

            // Send email using UserEmail Mailable
            Mail::to($recipient->email)->send(
                new UserEmail(
                    $validated['email_title'],
                    $validated['email_content'],
                    $filenames // Pass array of filenames
                )
            );

            $attachmentCount = count($filenames);
            $message = 'Email sent successfully to ' . $recipient->email;
            if ($attachmentCount > 0) {
                $message .= ' with ' . $attachmentCount . ' attachment(s)';
            }

            return redirect()->route('admin.users.show', $recipient->id)
                ->with('success', $message);
        } catch (\Exception $e) {
            // Clean up uploaded files if email sending fails
            if (!empty($filenames)) {
                foreach ($filenames as $filename) {
                    if (Storage::disk('public')->exists('attachments/' . $filename)) {
                        Storage::disk('public')->delete('attachments/' . $filename);
                    }
                }
            }

            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput();
        }
    }
}
