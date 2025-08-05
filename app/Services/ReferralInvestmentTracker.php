<?php
// app/Services/ReferralInvestmentTracker.php

namespace App\Services;

use App\Models\User;
use App\Models\Investment;
use App\Models\LeaderboardStage;
use App\Models\LeaderboardUserProgress;
use Illuminate\Support\Facades\DB;

class ReferralInvestmentTracker
{
    public function calculateTotalReferralInvestments(User $user): float
    {
        return (float) Investment::whereHas('user', function ($query) use ($user) {
            $query->where('referred_by', $user->id);
        })
            ->where('status', true)
            ->sum('amount');
    }


    public function updateUserLeaderboardProgress(User $user): void
    {
        $totalInvestments = $this->calculateTotalReferralInvestments($user);
        $stages = LeaderboardStage::active()->ordered()->get();

        DB::transaction(function () use ($user, $stages, $totalInvestments) {
            foreach ($stages as $stage) {
                $isCompleted = $totalInvestments >= $stage->target_amount;

                LeaderboardUserProgress::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'stage_id' => $stage->id
                    ],
                    [
                        'current_amount' => $totalInvestments,
                        'is_completed' => $isCompleted,
                        'completed_at' => $isCompleted ? now() : null
                    ]
                );
            }
        });
    }
}
