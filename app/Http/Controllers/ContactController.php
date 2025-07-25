<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submitForm(ContactFormRequest $request)
    {
        try {
            $data = $request->validated();
            $adminEmail = env('KYC_ADMIN_EMAIL');

            if (empty($adminEmail)) {
                throw new \Exception('Admin email is not configured');
            }

            // Send email
            Mail::to($adminEmail)->send(new ContactFormMail($data));

            $message = 'Thank you for your message. We will get back to you soon!';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while submitting your message. Please try again later.');
        }
    }
}
