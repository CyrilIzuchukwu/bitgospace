<?php
// app/Http/Controllers/User/LeaderboardController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\LeaderboardStage;
use App\Models\User;
use App\Services\ReferralInvestmentTracker;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function index()
    {



        $user = Auth::user();
        $tracker = new ReferralInvestmentTracker();

        // Debug code - START (remove after checking)
        // $referrals = User::where('referred_by', auth()->id())->pluck('id');
        // $investments = Investment::whereIn('user_id', $referrals)
        //     ->where('status', true)
        //     ->get(['amount', 'created_at']);

        // dd($investments->sum('amount'), $investments);

        // Update progress
        // Ensure we get a float value
        $totalInvestments = (float) $tracker->calculateTotalReferralInvestments($user);
        $tracker->updateUserLeaderboardProgress($user);


          $user = Auth::user();
    $tracker = new ReferralInvestmentTracker();

    // 1. Get RAW calculation first
    $rawTotal = (float) Investment::whereHas('user', function($q) use ($user) {
        $q->where('referred_by', $user->id);
    })->where('status', true)->sum('amount');

    // 2. Get the tracker calculation
    $trackerTotal = (float) $tracker->calculateTotalReferralInvestments($user);

    // 3. Debug output
    // dd([
    //     'raw_db_query_result' => $rawTotal,
    //     'tracker_method_result' => $trackerTotal,
    //     'referrals_count' => User::where('referred_by', $user->id)->count(),
    //     'investments_example' => Investment::whereHas('user', function($q) use ($user) {
    //         $q->where('referred_by', $user->id);
    //     })->where('status', true)->limit(5)->get()
    // ]);

        // Get all stages with progress
        $stages = LeaderboardStage::with(['userProgress' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
            ->active()
            ->ordered()
            ->get()
            ->map(function ($stage) use ($totalInvestments) {
                // Ensure we have progress data
                if ($stage->userProgress->isEmpty()) {
                    $stage->current_amount = 0;
                    $stage->is_completed = false;
                } else {
                    $stage->current_amount = $stage->userProgress->first()->current_amount;
                    $stage->is_completed = $stage->userProgress->first()->is_completed;
                }

                // Calculate progress percentage
                $stage->progress_percent = $stage->target_amount > 0
                    ? min(100, ($stage->current_amount / $stage->target_amount) * 100)
                    : 0;

                return $stage;
            });

        // Get next stage to complete
        $nextStage = $stages->firstWhere('is_completed', false);

        return view('user.leaderboard.index', [
            'stages' => $stages,
            'totalInvestments' => $totalInvestments,
            'nextStage' => $nextStage
        ]);
    }
}
