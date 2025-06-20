<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow access for guests or admins
        if (!$user || $user->role === 'admin') {
            return $next($request);
        }

        // Get the latest KYC verification
        $latestKyc = $user->kycVerifications()->latest()->first();

        // If no KYC exists
        if (!$latestKyc) {
            return redirect()
                ->route('user.kyc')
                ->with('info', 'You must complete KYC verification to access this feature.');
        }

        // Check KYC status
        switch ($latestKyc->status) {
            case 'approved':
                return $next($request);

            case 'pending':
            case 'in_review':
                return redirect()
                    ->route('user.kyc.status')
                    ->with('info', 'Your KYC submission is under review. Please wait for approval.');

            case 'rejected':
                return redirect()
                    ->route('user.kyc')
                    ->with('info', 'Your KYC was rejected. Please resubmit with correct information.');

            default:
                return redirect()
                    ->route('user.kyc')
                    ->with('error', 'You must complete KYC verification to access this feature.');
        }
    }
}
