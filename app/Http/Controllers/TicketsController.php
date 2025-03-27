<?php

namespace App\Http\Controllers;

use App\DataTables\TicketsDataTable;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketsRequest;
use App\Http\Requests\UpdateTicketsRequest;
use App\Models\Category;
use App\Models\Label;
use App\Models\Priority;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreatedMail;
use App\Traits\HandlesFilesTrait;
use App\Traits\AuthUserHelper;
use App\Traits\AdminCheck;

class TicketsController extends Controller
{
    use HandlesFilesTrait, AuthUserHelper, AdminCheck;

    /**
     * Display a listing of the tickets.
     */
    public function index(TicketsDataTable $dataTable)
    {
        return $dataTable->render('tickets.index');
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        $categories = Category::all();
        $labels     = Label::all();
        $priorities = Priority::all();
        return view('tickets.create', compact('categories', 'labels', 'priorities'));
    }

    /**
     * Store a newly created ticket.
     */
    public function store(StoreTicketsRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $this->currentUserId();
        $ticket = Tickets::create($data);

        // Process file attachments
        if ($request->hasFile('files')) {
            $this->handleFiles($ticket, $request->file('files'));
        }

        // Attach categories and labels
        if ($request->has('categories')) {
            $ticket->categories()->sync(array_filter($request->input('categories')));
        }
        if ($request->has('labels')) {
            $ticket->labels()->sync(array_filter($request->input('labels')));
        }

        // Send email notification to the administrator
        $admin = User::role('Administrator')->first();
        if ($admin) {
            $editLink = route('tickets.edit', $ticket->id);
            Mail::to($admin->email)->queue(new TicketCreatedMail($ticket, $editLink));
        }

        return response()->json([
            'success' => 'Ticket created successfully.',
            'ticket'  => $ticket,
        ]);
    }

    /**
     * Display the specified ticket.
     */
    public function show(Tickets $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(Tickets $ticket)
    {
        $user = $this->currentUser();
        if ($user->hasRole('Administrator') || ($user->hasRole('Agent') && $ticket->agent_id == $user->id)) {
            $agents = $user->hasRole('Administrator') ? User::role('Agent')->get() : [];
            $priorities = Priority::all();
            $allCategories = Category::all();
            $allLabels = Label::all();
            return view('tickets.edit', compact('ticket', 'agents', 'allCategories', 'allLabels', 'priorities'));
        }
        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified ticket.
     */
    public function update(UpdateTicketsRequest $request, Tickets $ticket)
    {
        $user = $this->currentUser();
        if (!($user->hasRole('Administrator') || ($user->hasRole('Agent') && $ticket->agent_id == $user->id))) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();
        $ticket->update($data);

        // Sync categories and labels
        $ticket->categories()->sync($request->input('categories', []));
        $ticket->labels()->sync($request->input('labels', []));

        // Handle removed files
        if ($request->filled('removed_files')) {
            $removedFileIds = is_array($request->removed_files)
                ? $request->removed_files
                : explode(',', $request->removed_files);
            $this->removeFiles($ticket, $removedFileIds);
        }

        // Handle new file attachments
        if ($request->hasFile('files')) {
            $this->handleFiles($ticket, $request->file('files'));
        }

        return response()->json([
            'success' => 'Ticket updated successfully.',
            'ticket'  => $ticket
        ]);
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(Tickets $ticket)
    {
        $user = $this->currentUser();
        if ($user->hasRole('Administrator') || ($user->hasRole('Agent') && $ticket->agent_id == $user->id)) {
            $ticket->delete();
            return response()->json(['success' => 'Ticket deleted successfully.']);
        }
        abort(403, 'Unauthorized action.');
    }
}
