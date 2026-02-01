<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AmbassadorRequestMail;
use App\Models\AmbassadorReward;
use App\Services\AmbassadorService;
use Illuminate\Support\Facades\Auth;

class UserAmbassadorController extends Controller
{

    protected $ambassadorService;

    public function __construct(AmbassadorService $ambassadorService)
    {
        $this->ambassadorService = $ambassadorService;
    }


    public function ambassador()
    {
        // Fetch all active rewards, ordered by required_referrals ascending
        $rewards = AmbassadorReward::where('status', 'active')
            ->orderBy('required_referrals', 'asc')
            ->get();

        return view('user.ambassador.index', compact('rewards'));
    }



    public function milestone()
    {
        $user = Auth::user();

        // Get complete milestone data using the service
        $milestoneData = $this->ambassadorService->getMilestoneData($user);

        // Calculate progress percentage
        $progress_percentage = $milestoneData['next_milestone']
            ? min(100, ($milestoneData['active_referrals_count'] / $milestoneData['next_milestone']->required_referrals) * 100)
            : 100;

        // Get current milestone LEVEL based on how many milestones have been achieved
        $achieved_milestones_count = AmbassadorReward::where('status', 'active')
            ->where('required_referrals', '<=', $milestoneData['active_referrals_count'])
            ->count();

        // If user has achieved milestones, use that count; otherwise start at level 1
        // Add 1 because if you've achieved 1 milestone, you're on level 2, etc.
        $current_milestone_level = $achieved_milestones_count > 0
            ? $achieved_milestones_count + 1
            : 1;

        // ALTERNATIVE: If you want the level to match the number of achieved milestones exactly:
        // $current_milestone_level = max(1, $achieved_milestones_count);

        // Add these to the milestone data array
        $milestoneData['progress_percentage'] = round($progress_percentage, 1);
        $milestoneData['current_milestone_level'] = $current_milestone_level;

        return view('user.ambassador.milestone', $milestoneData);
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
