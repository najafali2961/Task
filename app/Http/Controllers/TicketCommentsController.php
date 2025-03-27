<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketCommentsController extends Controller
{
    public function store(Request $request, Tickets $ticket)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = $ticket->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'success' => 'Comment added successfully.',
            'comment' => $comment
        ]);
    }
}
