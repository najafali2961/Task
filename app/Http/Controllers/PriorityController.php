<?php

namespace App\Http\Controllers;

use App\DataTables\PrioritiesDataTable;
use App\Models\Priority;
use Illuminate\Http\Request;
use App\Traits\AdminCheck;

class PriorityController extends Controller
{
    /**
     * Helper method to ensure only administrators access these routes.
     */
    use AdminCheck;

    /**
     * Display a listing of the priorities.
     */
    public function index(PrioritiesDataTable $dataTable)
    {
        $this->checkAdmin();
        return $dataTable->render('admin.priorities.index');
    }

    /**
     * Show the form for creating a new priority.
     */
    public function create()
    {
        $this->checkAdmin();
        return view('admin.priorities.create');
    }

    /**
     * Store a newly created priority.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:priorities,name'
        ]);

        $priority = Priority::create($request->only('name'));

        return response()->json([
            'success'  => 'Priority created successfully.',
            'priority' => $priority
        ]);
    }

    /**
     * Show the form for editing the specified priority.
     */
    public function edit(Priority $priority)
    {
        $this->checkAdmin();
        return view('admin.priorities.edit', compact('priority'));
    }

    /**
     * Update the specified priority.
     */
    public function update(Request $request, Priority $priority)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:priorities,name,' . $priority->id
        ]);

        $priority->update($request->only('name'));

        return response()->json([
            'success'  => 'Priority updated successfully.',
            'priority' => $priority
        ]);
    }

    /**
     * Remove the specified priority.
     */
    public function destroy(Priority $priority)
    {
        $this->checkAdmin();
        $priority->delete();
        return response()->json(['success' => 'Priority deleted successfully.']);
    }
}
