<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AmbassadorReward;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AmbassadorRewardController extends Controller
{
    /**
     * Display a listing of ambassador rewards
     */
    public function index()
    {
        $rewards = AmbassadorReward::latest()->paginate(10);
        return view('admin.ambassador.rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new reward
     */
    public function create()
    {
        return view('admin.ambassador.rewards.create');
    }

    /**
     * Store a newly created reward in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:ambassador_rewards,title|max:255',
            'required_referrals' => 'required|integer|min:1',
            'reward_type' => 'required|in:cash,trip,luxury_item,mixed',
            'cash_amount' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $data = $validated;
            $data['slug'] = Str::slug($data['title']);

            AmbassadorReward::create($data);

            return redirect()->route('ambassador.rewards.index')
                ->with('success', 'Ambassador reward created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating reward: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified reward
     */
    public function edit(AmbassadorReward $reward)
    {
        return view('admin.ambassador.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified reward in database
     */
    public function update(Request $request, AmbassadorReward $reward)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:ambassador_rewards,title,' . $reward->id,
            'required_referrals' => 'required|integer|min:1',
            'reward_type' => 'required|in:cash,trip,luxury_item,mixed',
            'cash_amount' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $reward->update([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'required_referrals' => $validated['required_referrals'],
                'reward_type' => $validated['reward_type'],
                'cash_amount' => $validated['cash_amount'],
                'description' => $validated['description'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('ambassador.rewards.index')
                ->with('success', 'Ambassador reward updated successfully.');
        } catch (Exception $e) {
            return back()->withInput()
                ->with('error', 'Error updating reward: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified reward from database
     */
    public function delete($id)
    {
        try {
            $reward = AmbassadorReward::findOrFail($id);
            $reward->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ambassador reward deleted successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reward not found.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reward.'
            ], 500);
        }
    }
}
