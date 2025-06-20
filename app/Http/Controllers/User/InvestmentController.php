<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Plan;
use App\Models\ReferralCommission;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Str;

class InvestmentController extends Controller
{
    //


    public function trades()
    {
        $plans = Plan::where('status', 'active')->oldest()->get();
        return view('user.investments.plans', compact('plans'));
    }



    // investment history
    public function investmentHistory()
    {

        $userId = Auth::id();
        $investments = Investment::with('plan')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('user.investments.investment', compact('investments'));
    }


    public function startInvestment(Plan $plan)
    {
        // $plan is already the resolved model instance
        return view('user.investments.start-investment', compact('plan'));
    }


    public function validateInvestment(Request $request)
    {
        // Start transaction
        DB::beginTransaction();

        try {
            // Validate basic input
            $validated = $request->validate([
                'plan_id' => 'required|integer|exists:plans,id',
                'amount' => 'required|numeric|min:0.01|decimal:0,2',
            ]);

            // Lock the plan and user records for update to prevent race conditions
            $plan = Plan::lockForUpdate()->findOrFail($validated['plan_id']);
            $user = Auth::user();
            $wallet = $user->wallet()->lockForUpdate()->firstOrFail();


            // Validate plan status
            if ($plan->status !== 'active') {
                throw ValidationException::withMessages([
                    'plan' => 'This plan is currently not available for investment'
                ]);
            }

            // Validate amount against plan limits
            if ($validated['amount'] < $plan->minimum_amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Minimum investment for this plan is $' . number_format($plan->minimum_amount, 2)
                ]);
            }

            if ($validated['amount'] > $plan->maximum_amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Maximum investment for this plan is $' . number_format($plan->maximum_amount, 2)
                ]);
            }

            // Validate wallet balance with precise decimal comparison
            if (bccomp($wallet->balance, $validated['amount'], 2) === -1) {
                throw ValidationException::withMessages([
                    'amount' => 'Insufficient balance. Available: $' . number_format($wallet->balance, 2)
                ]);
            }

            // Verify wallet is active
            if (!$wallet->status) {
                throw ValidationException::withMessages([
                    'wallet' => 'Your wallet is currently inactive'
                ]);
            }

            // All validations passed - commit transaction
            DB::commit();
            $request->session()->put('investment_data', [
                'plan_id' => $plan->id,
                'amount' => $validated['amount'],
                'plan_details' => $plan->toArray(), // Convert to array for session storage
                'wallet_balance' => $wallet->balance
            ]);

            return redirect()->route('user.confirm-investment');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'The requested plan or wallet could not be found');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Investment validation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'plan_id' => $request->plan_id,
                'amount' => $request->amount
            ]);
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }



    public function confirmInvestment(Request $request)
    {


        $investmentData = $request->session()->get('investment_data');

        if (!$investmentData) {
            return redirect()->route('user.trades')->with('error', 'Invalid investment session');
        }

        $plan = Plan::find($investmentData['plan_id']);
        $amount = $investmentData['amount'];

        if (!$plan) {
            return redirect()->route('user.trades')->with('error', 'Plan not found');
        }

        return view('user.investments.confirm-investment', [
            'plan' => $plan,
            'amount' => $amount,
            'investmentData' => $investmentData
        ]);
    }



    public function processInvestment(Request $request)
    {
        // dd('why');
        // Validate the request
        $validated = $request->validate([
            'terms_agreed' => 'required|accepted',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0.01|decimal:0,2'
        ]);

        // dd($validated);

        // Start transaction
        DB::beginTransaction();

        try {
            // Lock necessary records
            $plan = Plan::lockForUpdate()->findOrFail($request->plan_id);
            $user = Auth::user();
            $wallet = $user->wallet()->lockForUpdate()->firstOrFail();



            // Validate investment conditions
            if ($plan->status !== 'active') {
                throw new \Exception('This plan is currently not available for investment');
            }

            if ($request->amount < $plan->minimum_amount) {
                throw new \Exception('Minimum investment for this plan is $' . number_format($plan->minimum_amount, 2));
            }

            if ($request->amount > $plan->maximum_amount) {
                throw new \Exception('Maximum investment for this plan is $' . number_format($plan->maximum_amount, 2));
            }

            if (bccomp($wallet->balance, $request->amount, 2) === -1) {
                throw new \Exception('Insufficient balance. Available: $' . number_format($wallet->balance, 2));
            }

            if (!$wallet->status) {
                throw new \Exception('Your wallet is currently inactive');
            }

            // Calculate values
            $dailyProfit = $request->amount * ($plan->interest_rate / 100);
            $totalRoi = $dailyProfit * $plan->duration;



            $reference = 'INV-' . now()->format('ymdHis') . '-' . strtoupper(Str::random(5));
            // Create investment with your schema structure
            $investment = Investment::create([
                'reference' => $reference,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $request->amount,
                'status' => true,
                'profit' => 0,
                'roi' => $totalRoi,
                'start_date' => now(),
                'end_date' => now()->addDays($plan->duration),
                'withdrawn' => false,
                'due' => false
            ]);

            // Deduct from balance
            $wallet->decrement('balance', $request->amount);

            // ✅ Create transaction record for investment debit
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'investment',
                'status' => 'completed',
                'description' => 'Investment into ' . $plan->name . ' plan',
                'reference' => $reference,
            ]);


            DB::commit();

            // Process referral commissions (NEW CODE)
            $this->processReferralCommissions($user, $request->amount, $reference, $investment);

            // Clear the session data
            $request->session()->forget('investment_data');

            return redirect()->route('user.investment-list')->with('success', 'Investment created successfully! Your daily profit will be $' . number_format($dailyProfit, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Investment processing failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'plan_id' => $request->plan_id,
                'amount' => $request->amount
            ]);

            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Process 3-level referral commissions
     */
    protected function processReferralCommissions($investingUser, $investmentAmount, $reference, Investment $investment)
    {
        $commissionLevels = [
            1 => 0.10, // 10% for level 1 (direct referral)
            2 => 0.04, // 4% for level 2
            3 => 0.015, // 1.5% for level 3
        ];

        $currentUser = $investingUser;
        $level = 1;

        while ($level <= 3 && $currentUser->referred_by) {
            $referrer = User::lockForUpdate()->find($currentUser->referred_by);

            if (!$referrer) {
                break;
            }

            $referrerWallet = $referrer->wallet()->lockForUpdate()->first();

            if ($referrerWallet) {
                $commission = $investmentAmount * $commissionLevels[$level];

                // Credit referrer's wallet
                $referrerWallet->increment('balance', $commission);

                // Create commission transaction
                Transaction::create([
                    'user_id' => $referrer->id,
                    'amount' => $commission,
                    'type' => 'referral_commission',
                    'status' => 'completed',
                    'description' => 'Level ' . $level . ' referral commission from ' . $investingUser->name,
                    'reference' => 'COM-' . $reference,
                ]);

                // Create referral commission record (you might want to track this separately)
                ReferralCommission::create([
                    'referrer_id' => $referrer->id,
                    'investor_id' => $investingUser->id,
                    'investment_id' => $investment->id,
                    'level' => $level,
                    'amount' => $commission,
                    'percentage' => $commissionLevels[$level] * 100,
                ]);
            }

            $currentUser = $referrer;
            $level++;
        }
    }





    public function withdrawInvestment(Investment $investment)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Verify the investment belongs to the authenticated user
        abort_if($investment->user_id !== $user->id, 403);

        // Check if investment is eligible for withdrawal
        if (!$investment->due || $investment->withdrawn) {
            return back()->with('error', 'This investment is not eligible for withdrawal');
        }

        DB::transaction(function () use ($investment, $user) {
            // Get the user's wallet
            $wallet = $user->wallet()->lockForUpdate()->first();

            // Add the profit to wallet balance
            $wallet->increment('balance', $investment->profit);

            // Mark investment as withdrawn
            $investment->update(['withdrawn' => true]);

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $investment->profit,
                'type' => 'investment_withdrawal',
                'status' => 'completed',
                'description' => 'Profit withdrawal from ' . $investment->plan->name,
                'reference' => 'INV-WDR-' . time()
            ]);
        });

        return back()->with('success', 'Profit withdrawn successfully!');
    }
}
