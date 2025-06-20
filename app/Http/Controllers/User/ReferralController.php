<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReferralCommission;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $referralLink = $user->referral_link;

        // Get quick stats
        $totalReferrals = User::where('referred_by', $user->id)->count();
        $activeReferrals = User::where('referred_by', $user->id)
            ->whereHas('investments')
            ->count();
        $totalCommissions = ReferralCommission::where('referrer_id', $user->id)
            ->sum('amount');

        return view('user.referrals.index', compact(
            'referralLink',
            'totalReferrals',
            'activeReferrals',
            'totalCommissions'
        ));
    }

    public function referredUsers()
    {
        $users = User::withCount(['investments'])
            ->withSum('investments', 'amount')
            ->where('referred_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.referrals.users', compact('users'));
    }

    public function commissions()
    {
        $commissions = ReferralCommission::with(['investor', 'investment'])
            ->where('referrer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('user.referrals.commissions', compact('commissions'));
    }


}
