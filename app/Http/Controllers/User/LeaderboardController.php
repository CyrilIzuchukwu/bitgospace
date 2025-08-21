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

        // Calculate total investments using the service method for consistency
        $referralTotal  = (float)$tracker->calculateTotalReferralInvestments($user);

        // Update progress with this consistent value
        $tracker->updateUserLeaderboardProgress($user);

        // Get stages with progress
        $stages = LeaderboardStage::with(['userProgress' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
            ->active()
            ->ordered()
            ->get()
            ->map(function ($stage) use ($referralTotal) {
                $stage->current_amount = $referralTotal;
                $stage->is_completed = $referralTotal  >= $stage->target_amount;
                $stage->progress_percent = $stage->target_amount > 0
                    ? min(100, ($referralTotal  / $stage->target_amount) * 100)
                    : 0;
                return $stage;
            });

        $nextStage = $stages->firstWhere('is_completed', false);

        // dd($referralTotal , $stages->pluck('current_amount'));

        return view('user.leaderboard.index', [
            'stages' => $stages,
            'referralTotal' => $referralTotal,
            'nextStage' => $nextStage
        ]);
    }
}
