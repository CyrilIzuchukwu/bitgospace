<?php

namespace App\Services;

use App\Models\User;
use App\Models\AmbassadorReward;
use Illuminate\Support\Facades\DB;

class AmbassadorService
{
    /**
     * Get the count of active referrals for a user
     * Active = referred user has at least one investment
     */
    public function getActiveReferralsCount(User $user): int
    {
        return User::where('referred_by', $user->id)
            ->whereHas('investments') // Has at least one investment
            ->count();
    }

    /**
     * Get all referrals with their investment status
     */
    public function getReferralsWithStatus(User $user)
    {
        return User::where('referred_by', $user->id)
            ->withCount('investments')
            ->get()
            ->map(function ($referral) {
                return [
                    'name' => $referral->name,
                    'email' => $referral->email,
                    'is_active' => $referral->investments_count > 0,
                    'investment_count' => $referral->investments_count,
                    'joined_date' => $referral->created_at->format('M d, Y'),
                ];
            });
    }

    /**
     * Get next milestone reward for user
     */
    public function getNextMilestone(int $activeReferralsCount)
    {
        return AmbassadorReward::where('status', 'active')
            ->where('required_referrals', '>', $activeReferralsCount)
            ->orderBy('required_referrals', 'asc')
            ->first();
    }

    /**
     * Get current achieved milestone
     */
    public function getCurrentMilestone(int $activeReferralsCount)
    {
        return AmbassadorReward::where('status', 'active')
            ->where('required_referrals', '<=', $activeReferralsCount)
            ->orderBy('required_referrals', 'desc')
            ->first();
    }

    /**
     * Get all milestones with progress
     */
    public function getAllMilestonesWithProgress(int $activeReferralsCount)
    {
        $rewards = AmbassadorReward::where('status', 'active')
            ->orderBy('required_referrals', 'asc')
            ->get();

        return $rewards->map(function ($reward) use ($activeReferralsCount) {
            $isAchieved = $activeReferralsCount >= $reward->required_referrals;
            $progress = $isAchieved ? 100 : min(100, ($activeReferralsCount / $reward->required_referrals) * 100);
            $remaining = max(0, $reward->required_referrals - $activeReferralsCount);

            return [
                'reward' => $reward,
                'is_achieved' => $isAchieved,
                'progress' => round($progress, 1),
                'remaining' => $remaining,
            ];
        });
    }

    /**
     * Get complete milestone data for a user
     */
    public function getMilestoneData(User $user): array
    {
        $activeReferralsCount = $this->getActiveReferralsCount($user);
        $totalReferrals = User::where('referred_by', $user->id)->count();
        $nextMilestone = $this->getNextMilestone($activeReferralsCount);
        $currentMilestone = $this->getCurrentMilestone($activeReferralsCount);
        $allMilestones = $this->getAllMilestonesWithProgress($activeReferralsCount);

        return [
            'active_referrals_count' => $activeReferralsCount,
            'total_referrals' => $totalReferrals,
            'inactive_referrals' => $totalReferrals - $activeReferralsCount,
            'next_milestone' => $nextMilestone,
            'current_milestone' => $currentMilestone,
            'all_milestones' => $allMilestones,
            'referrals_list' => $this->getReferralsWithStatus($user),
        ];
    }
}
