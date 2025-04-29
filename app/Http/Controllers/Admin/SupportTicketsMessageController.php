<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketsMessageController extends Controller
{
    public function store(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'message' => $request->message,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        if ($request->has('close')) {
            $ticket->update([
                'status' => 'closed',
            ]);
        }

        return redirect()->route('admin.support-tickets.show', $ticket->id)
            ->with('success', 'تم إرسال الرد بنجاح.');
    }
}
