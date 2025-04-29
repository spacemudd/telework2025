<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $openTickets = SupportTicket::where('status', 'open');
        $latestActivities = \Spatie\Activitylog\Models\Activity::latest()->take(5)->with('causer')->get();
        return view('admin.dashboard', compact('openTickets', 'latestActivities'));
    }
}
