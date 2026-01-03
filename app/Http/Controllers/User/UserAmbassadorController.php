<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AmbassadorRequestMail;
use Illuminate\Support\Facades\Auth;

class UserAmbassadorController extends Controller
{
    public function ambassador()
    {
        return view('user.ambassador.index');
    }


    public function requestAmbassadorship(Request $request)
    {
        try {
            $userM = Auth::user();

            // Check if already an ambassador
            if ($userM->is_ambassador) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already an ambassador.'
                ]);
            }

            // Check if request is already pending
            if ($userM->ambassador_request_status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your request is already pending approval.'
                ]);
            }

            // Update request status to pending
            $userM->update([
                'ambassador_request_status' => 'pending'
            ]);

            // Get admin email from env
            $adminEmail = env('KYC_ADMIN_EMAIL', 'hello@bitgospace.com');

            // Send email to admin
            Mail::to($adminEmail)->send(new AmbassadorRequestMail(
                $userM->name,
                $userM->email,
                $userM->id
            ));

            return response()->json([
                'success' => true,
                'message' => 'Your ambassador request has been submitted successfully. Our team will review it shortly.',
                'status' => 'pending'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit request. Please try again later.'
            ], 500);
        }
    }
}
