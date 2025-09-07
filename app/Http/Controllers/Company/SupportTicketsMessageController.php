<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketsMessageController extends Controller
{
    public function store(Request $request, SupportTicket $ticket)
    {
        $company = auth()->user()->owned_company;
        
        if (!$company) {
            return redirect()->route('onboarding.company')->with('error', 'يرجى إكمال إعداد الشركة أولاً');
        }
        
        // Ensure the support ticket belongs to the authenticated user's company
        if ($ticket->supportable_id !== $company->id || $ticket->supportable_type !== get_class($company)) {
            abort(403, 'Unauthorized access to support ticket');
        }
        
        $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'message' => $request->message,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        return redirect()->route('company.support-tickets.show', $ticket->id)
            ->with('success', 'تم إرسال الرد بنجاح.');
    }
}
