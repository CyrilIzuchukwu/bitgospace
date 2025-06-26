<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    public function support()
    {
        $tickets = Ticket::withCount('messages')
            ->with('user') // Eager load the user relationship
            ->latest()
            ->paginate(10);

        return view('admin.support.index', compact('tickets'));
    }



    public function viewTicket($reference_id)
    {
        $ticket = Ticket::with(['user.profile', 'messages.user.profile'])
            ->where('reference_id', $reference_id)
            ->firstOrFail();

        return view('admin.support.view-ticket', compact('ticket'));
    }



    public function addMessage(Request $request, $reference_id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        try {
            $ticket = Ticket::where('reference_id', $reference_id)->firstOrFail();

            if ($ticket->status !== 'open') {
                return response()->json(['success' => false, 'message' => 'Ticket is closed.'], 400);
            }

            $attachmentPath = $request->hasFile('attachment')
                ? $request->file('attachment')->store('ticket-attachments', 'public')
                : null;

            $message = $ticket->messages()->create([
                'user_id' => Auth::id(),
                'message' => $request->message,
                'attachment_path' => $attachmentPath,
                'is_admin' => true,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sent!',
                'data' => [
                    'message' => $message->message,
                    'time' => $message->created_at->format('h:i A'),
                    'is_admin' => true,
                    'attachment_path' => $attachmentPath ? asset('storage/' . $attachmentPath) : null,
                    'attachment_extension' => $attachmentPath ? pathinfo($attachmentPath, PATHINFO_EXTENSION) : null,
                    'sender_name' => 'You',
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ], 500);
        }
    }


    public function closeTicket($reference_id)
    {
        try {
            $ticket = Ticket::where('reference_id', $reference_id)->firstOrFail();
            $ticket->update(['status' => 'closed']);

            return response()->json(['success' => true, 'message' => 'Ticket closed successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error closing ticket.'], 500);
        }
    }
}
