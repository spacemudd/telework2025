<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportTicketsController extends Controller
{
    function index()
    {
        $company = $this->getCurrentCompany();
        $tickets = $company->supportTickets()
            ->with(['supportable'])
            ->latest()
            ->paginate(10);
        return view('company.support_tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('company.support_tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $company = $this->getCurrentCompany();

        $ticket = $company->supportTickets()->create([
            'subject' => $request->subject,
            'status' => 'open',
        ]);

        $ticket->messages()->create([
            'message' => $request->message,
            'sender_type' => get_class(auth()->user()),
            'sender_id' => auth()->id(),
        ]);

        return redirect()->route('company.support-tickets.index')
            ->with('success', 'تم إرسال التذكرة بنجاح.');
    }

    public function show($id)
    {
        $company = $this->getCurrentCompany();
        
        $ticket = $company->supportTickets()
            ->with(['messages.sender'])
            ->findOrFail($id);

        return view('company.support_tickets.show', compact('ticket'));
    }

    private function getCurrentCompany()
    {
        $user = auth()->user();
        $selectedCompanyId = session('selected_company_id');
        
        if ($selectedCompanyId) {
            $company = $user->companies()->where('company_id', $selectedCompanyId)->first();
            if ($company) {
                return $company;
            }
        }
        
        // Fallback to primary company or first available company
        $company = $user->primaryCompany;
        if (!$company && $user->companies()->exists()) {
            $company = $user->companies()->first();
        }
        
        if (!$company) {
            abort(403, 'You are not associated with any company.');
        }
        
        return $company;
    }
}
