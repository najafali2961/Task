<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Traits\AdminCheck;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AdminCheck;
    public function index()
    {
        $this->checkAdmin();

        $totalTickets      = Tickets::count();
        $openTickets       = Tickets::where('status', 'open')->count();
        $closedTickets     = Tickets::where('status', 'closed')->count();
        $unassignedTickets = Tickets::whereNull('agent_id')->count();

        return view('dashboard', compact('totalTickets', 'openTickets', 'closedTickets', 'unassignedTickets'));
    }
}
