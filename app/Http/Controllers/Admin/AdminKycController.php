<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KycApprovedMail;
use App\Models\KycVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminKycController extends Controller
{
    //

    public function index()
    {
        $kycs = KycVerification::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.kyc.index', compact('kycs'));
    }



    public function show($id)
    {
        $kyc = KycVerification::with('user')->findOrFail($id);

        // Update status to in_review when admin views it
        if ($kyc->status === 'pending') {
            $kyc->update([
                'status' => 'in_review',
                'reviewed_at' => Carbon::now()
            ]);
        }

        return view('admin.kyc.show', compact('kyc'));
    }


    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $kyc = KycVerification::findOrFail($id);
            $user = $kyc->user;

            // ✅ Send email before updating anything
            Mail::to($user->email)->send(new KycApprovedMail($user));

            // ✅ Now update KYC status
            $kyc->update([
                'status' => 'approved',
                'reviewed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'KYC approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to approve KYC: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $kyc = KycVerification::findOrFail($id);

        $kyc->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'reviewed_at' => Carbon::now()
        ]);

        return back()->with('success', 'KYC rejected');
    }
}
