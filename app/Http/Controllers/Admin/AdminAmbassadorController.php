<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminAmbassadorController extends Controller
{
    public function requests()
    {

        $requests = User::where('ambassador_request_status', 'pending')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.ambassador.requests', compact('requests'));
    }

    public function approveRequest(User $user)
    {
        $user->update([
            'is_ambassador' => true,
            'ambassador_request_status' => 'approved'
        ]);

        return redirect()->back()->with('success', "{$user->name} has been approved as an ambassador.");
    }


    public function rejectRequest(User $user)
    {
        $user->update([
            'ambassador_request_status' => 'rejected'
        ]);

        return redirect()->back()->with('success', "{$user->name}'s ambassador request has been rejected.");
    }
}
