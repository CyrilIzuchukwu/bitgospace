<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaderboardStage;
use App\Models\User;
use App\Services\ReferralInvestmentTracker;
use Illuminate\Http\Request;

class AltLeadController extends Controller
{

    public function userProgress()
    {
        $tracker = new ReferralInvestmentTracker();

        $users = User::whereHas('investments', function ($query) {
            $query->where('status', 'completed');
        })
            ->orWhereHas('referrals.investments', function ($query) {
                $query->where('status', 'completed');
            })
            ->with(['profile', 'referrals.investments'])
            ->get()
            ->map(function ($user) use ($tracker) {
                $referralTotal = (float) $tracker->calculateTotalReferralInvestments($user);

                $stages = LeaderboardStage::active()->ordered()->get();
                $currentStage = null;
                $completedStages = 0;
                $nextStage = null;

                foreach ($stages as $stage) {
                    if ($referralTotal >= $stage->target_amount) {
                        $completedStages++;
                    } elseif (!$currentStage && $referralTotal < $stage->target_amount) {
                        $currentStage = $stage;
                        $nextStage = $stage;
                        break;
                    }
                }

                $user->referral_total = $referralTotal;
                $user->completed_stages = $completedStages;
                $user->current_stage = $currentStage;
                $user->next_stage = $nextStage;
                $user->progress_percentage = $nextStage
                    ? min(100, ($referralTotal / $nextStage->target_amount) * 100)
                    : 100;
                $user->total_stages = $stages->count();
                $user->referred_count = $user->referrals->count();

                return $user;
            })
            ->sortByDesc('referral_total');

        $stats = [
            'total_users' => $users->count(),
            'total_referral_volume' => $users->sum('referral_total'),
            'average_referral' => $users->avg('referral_total'),
            'top_performer' => $users->first(),
            'stages_count' => LeaderboardStage::active()->count(),
        ];

        $stages = LeaderboardStage::active()->ordered()->get();

        return view('admin.leaderboard.user-progress', compact('users', 'stats', 'stages'));
    }





}
