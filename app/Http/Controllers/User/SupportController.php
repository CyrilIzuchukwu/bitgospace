<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\NewTicketNotification;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{

    public function support()
    {
        $user = Auth::user();

        $tickets = Ticket::where('user_id', $user->id)
            ->withCount('messages')
            ->latest()
            ->paginate(10);

        return view('user.support.index', compact('tickets', 'user'));
    }


    public function createSupport()
    {
        return view('user/support/create-support');
    }


    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048' // 2MB max
        ]);

        $attachmentPath = null;
        $kycAdminEmail = env('KYC_ADMIN_EMAIL');

        try {
            // Start DB transaction
            DB::beginTransaction();

            // Handle file upload if present
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
            }

            // Prepare data for ticket (before saving)
            $referenceId = Ticket::generateReferenceId();
            $user = Auth::user();

            $data = [
                'ticketReference' => $referenceId,
                'subject' => $request->subject,
                'message' => $request->message,
                'userName' => $user->name,
                'userEmail' => $user->email,
                'createdAt' => now()->format('F j, Y \a\t g:i a'),
            ];

            // Send email first
            if ($kycAdminEmail) {
                try {
                    Mail::to($kycAdminEmail)->send(new NewTicketNotification($data));
                } catch (\Exception $mailException) {
                    DB::rollBack();
                    Log::error('Ticket email failed: ' . $mailException->getMessage());
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Ticket email could not be sent. Please try again.');
                }
            }

            // Create ticket only after successful email
            $ticket = Ticket::create([
                'reference_id' => $referenceId,
                'user_id' => $user->id,
                'subject' => $request->subject,
                'message' => $request->message,
                'attachment_path' => $attachmentPath,
                'status' => 'open'
            ]);

            // Create the first message
            $ticket->messages()->create([
                'user_id' => $user->id,
                'message' => $request->message,
                'attachment_path' => $attachmentPath,
                'is_admin' => false
            ]);

            // Commit DB changes
            DB::commit();

            return redirect()->route('user.ticket.view', $ticket->reference_id)->with('success', 'Ticket created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Ticket creation failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Error creating ticket: ' . $e->getMessage());
        }
    }

    public function viewTicket($reference_id)
    {
        $ticket = Ticket::where('reference_id', $reference_id)->with(['messages', 'messages.user'])->firstOrFail();

        return view('user.support.view-ticket', compact('ticket'));
    }


    // public function addMessage(Request $request, $reference_id)
    // {
    //     $request->validate([
    //         'message' => 'required|string',
    //         'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $ticket = Ticket::where('reference_id', $reference_id)->firstOrFail();

    //         // Authorization check
    //         if ($ticket->user_id !== Auth::id()) {
    //             abort(403, 'Unauthorized action.');
    //         }

    //         // Status check
    //         if ($ticket->status !== 'open') {
    //             return redirect()->back()
    //                 ->with('error', 'Cannot add messages to a closed ticket');
    //         }

    //         $attachmentPath = null;
    //         if ($request->hasFile('attachment')) {
    //             $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
    //         }

    //         $ticket->messages()->create([
    //             'user_id' => Auth::id(),
    //             'message' => $request->message,
    //             'attachment_path' => $attachmentPath,
    //             'is_admin' => false,
    //             'created_at' => now(),
    //         ]);

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Message sent!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Error adding message: ' . $e->getMessage());
    //     }
    // }


    public function addMessage(Request $request, $reference_id)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048'
        ]);

        try {
            $ticket = Ticket::where('reference_id', $reference_id)->firstOrFail();

            if ($ticket->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }

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
                'is_admin' => false,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sent!',
                'data' => [
                    'message' => $message->message,
                    'time' => $message->created_at->format('h:i A'),
                    'user_avatar' => Auth::user()->profile->profile_picture
                        ? asset('storage/profile_pictures/' . Auth::user()->profile->profile_picture)
                        : asset('dashboard_assets/assets/images/users/user-avatar.jpg'),
                    'attachment_path' => $attachmentPath ? asset('storage/' . $attachmentPath) : null
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ], 500);
        }
    }



    // public function closeTicket($reference_id)
    // {
    //     try {
    //         $ticket = Ticket::where('reference_id', $reference_id)->firstOrFail();
    //         $ticket->update(['status' => 'closed']);

    //         return redirect()->back()->with('success', 'Ticket closed successfully!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->with('error', 'Error closing ticket: ' . $e->getMessage());
    //     }
    // }

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



    // public function show($reference_id)
    // {
    //     $ticket = Ticket::where('reference_id', $reference_id)
    //         ->where('user_id', Auth::id())
    //         ->with(['messages' => function ($query) {
    //             $query->orderBy('created_at', 'asc');
    //         }])
    //         ->firstOrFail();

    //     return view('ticket.show', compact('ticket'));
    // }
}
