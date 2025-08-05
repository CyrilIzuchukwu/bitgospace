<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaderboardStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LeaderboardStageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages = LeaderboardStage::ordered()->paginate(2);
        return view('admin.leaderboard.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leaderboard.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        // dd($validated['description']);

        try {
            // Handle image upload if present
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('leaderboard', 'public');
            }

            LeaderboardStage::create($validated);

            DB::commit();

            return redirect()->route('admin.leaderboard.index')->with('success', 'Leaderboard stage created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Optional: Log the error for debugging
            Log::error('Failed to create leaderboard stage', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
            ]);

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaderboardStage $leaderboard)
    {
        return view('admin.leaderboard.show', compact('leaderboard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaderboardStage $leaderboard)
    {
        return view('admin.leaderboard.edit', compact('leaderboard'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaderboardStage $leaderboard)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($leaderboard->image) {
                Storage::disk('public')->delete($leaderboard->image);
            }
            $validated['image'] = $request->file('image')->store('leaderboard', 'public');
        }

        $leaderboard->update($validated);

        return redirect()->route('admin.leaderboard.index')
            ->with('success', 'Leaderboard stage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaderboardStage $leaderboard)
    {
        if ($leaderboard->image) {
            Storage::disk('public')->delete($leaderboard->image);
        }

        $leaderboard->delete();

        return redirect()->route('admin.leaderboard.index')
            ->with('success', 'Leaderboard stage deleted successfully.');
    }
}
