<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    //
    public function create()
    {
        return view('admin.plans.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:plans,name',
            'minimum_amount' => 'required|numeric|min:0',
            'maximum_amount' => 'required|numeric|gt:minimum_amount',
            'interest_rate' => 'required|numeric|between:0,100',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:days,months,years',
            'payout_frequency' => 'required|in:daily,weekly,monthly,end_of_term',
            'privileges' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $data = $validated;
            $data['slug'] = Str::slug($data['name']);

            // Handle privileges - convert to array if not empty
            $data['privileges'] = !empty($data['privileges'])
                ? json_encode(array_map('trim', explode(',', $data['privileges'])))
                : null;

            Plan::create($data);

            return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating plan: ' . $e->getMessage());
        }
    }



    public function index()
    {
        $plans = Plan::latest()->paginate(10);
        return view('admin.plans.index', compact('plans'));
    }


    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', ['plan' => $plan]);
    }


    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:plans,name,' . $plan->id,
            'minimum_amount' => 'required|numeric|min:0',
            'maximum_amount' => 'required|numeric|gt:minimum_amount',
            'interest_rate' => 'required|numeric|between:0,100',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:days,months,years',
            'payout_frequency' => 'required|in:daily,weekly,monthly,end_of_term',
            'privileges' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $plan->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'minimum_amount' => $validated['minimum_amount'],
                'maximum_amount' => $validated['maximum_amount'],
                'interest_rate' => $validated['interest_rate'],
                'duration' => $validated['duration'],
                'duration_type' => $validated['duration_type'],
                'payout_frequency' => $validated['payout_frequency'],
                'privileges' => !empty($validated['privileges']) ? json_encode(array_map('trim', explode(',', $validated['privileges']))) : null,
                'status' => $validated['status'],
            ]);

            return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating plan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $plan = Plan::findOrFail($id);
            $plan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Plan deleted successfully.'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Plan not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete plan.'
            ], 500);
        }
    }
}
