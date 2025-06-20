<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use Illuminate\Http\Request;

class AdminInvestmentController extends Controller
{
    //

    public function index(Request $request)
    {
        $query = Investment::with(['user', 'plan'])
            ->latest();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('due', false);
                    break;
                case 'completed':
                    $query->where('due', true);
                    break;
                case 'withdrawn':
                    $query->where('withdrawn', true);
                    break;
            }
        }

        $investments = $query->paginate(15);

        return view('admin.investments.index', compact('investments'));
    }


    public function show(Investment $investment)
    {
        return view('admin.investments.show', compact('investment'));
    }
}
