<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SupportTicketClosed;
use App\Mail\SupportTicketMessageUpdated;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportTicketsMessageController extends Controller
{
    public function store(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create the message
        $message = $ticket->messages()->create([
            'message' => $request->message,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        // Load the ticket's supportable (company) relationship
        $ticket->load('supportable');

        // Check if ticket should be closed
        if ($request->has('close')) {
            $ticket->update([
                'status' => 'closed',
            ]);
            
            // Send ticket closed email
            if ($ticket->supportable && $ticket->supportable->email) {
                Mail::to($ticket->supportable->email)->send(new SupportTicketClosed($ticket));
            }
        } else {
            // Send ticket message updated email
            if ($ticket->supportable && $ticket->supportable->email) {
                Mail::to($ticket->supportable->email)->send(new SupportTicketMessageUpdated($ticket, $message));
            }
        }

        return redirect()->route('admin.support-tickets.show', $ticket->id)
            ->with('success', 'تم إرسال الرد بنجاح.');
    }
}
