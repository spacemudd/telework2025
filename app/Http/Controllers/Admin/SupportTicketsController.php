<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketsMessage;
use Illuminate\Http\Request;

class SupportTicketsController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::latest()->paginate(20);
        return view('admin.support_tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $supportTicket)
    {
        $supportTicket->load('messages.sender', 'supportable');
        return view('admin.support_tickets.show', compact('supportTicket'));
    }
}
