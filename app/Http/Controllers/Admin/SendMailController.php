<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailjetApiService;
use App\Services\MailjetService;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function sendMail()
    {
        return view('admin.mail.index');
    }


    public function sendToAllUsers(Request $request, MailjetApiService $mailjetService)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt|max:15360',
        ]);

        try {
            // Get all users with role 'user'
            $users = User::where('role_as', 'user')->get();

            // Prepare recipients
            $recipients = $users->map(function ($user) {
                return [
                    'Email' => $user->email,
                    'Name' => $user->name,
                ];
            })->toArray();

            // Render email template
            $htmlContent = view('emails.bulk_user_email', [
                'emailData' => [
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'recipient_name' => 'User'
                ]
            ])->render();

            // Send via Mailjet API
            $success = $mailjetService->sendBulkEmail(
                $recipients,
                $request->subject,
                $htmlContent,
                $request->file('attachments', [])
            );

            if ($success) {
                return back()->with('success', 'Bulk email sent to all users');
            }

            return back()->with('error', 'Failed to send bulk email');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
