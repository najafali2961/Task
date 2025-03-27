<?php

namespace App\Observers;

use App\Models\Tickets;
use App\Models\TicketLog;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    public function created(Tickets $ticket)
    {
        TicketLog::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => $ticket->user_id,
            'action'      => 'created',
            'description' => 'Ticket created by user ID ' . $ticket->user_id,
        ]);
    }

    public function updated(Tickets $ticket)
    {
        TicketLog::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::check() ? Auth::id() : null,
            'action'      => 'updated',
            'description' => 'Ticket updated by user ID ' . (Auth::check() ? Auth::id() : 'unknown'),
        ]);
    }
}
