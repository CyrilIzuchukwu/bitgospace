<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $kyc = KycVerification::findOrFail($id);

        $kyc->update([
            'status' => 'approved',
            'reviewed_at' => Carbon::now()
        ]);

        return back()->with('success', 'KYC approved successfully');
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
