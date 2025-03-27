<?php

namespace App\Http\Controllers;

use App\DataTables\LabelsDataTable;
use App\Models\Label;
use Illuminate\Http\Request;
use App\Traits\AdminCheck;

class LabelController extends Controller
{
    use AdminCheck;
    /**
     * Ensure only administrators can access these routes.
     */


    /**
     * Display a listing of the labels using LabelsDataTable.
     */
    public function index(LabelsDataTable $dataTable)
    {
        $this->checkAdmin();
        return $dataTable->render('admin.labels.index');
    }

    /**
     * Show the form for creating a new label.
     */
    public function create()
    {
        $this->checkAdmin();
        return view('admin.labels.create');
    }

    /**
     * Store a newly created label in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:labels,name'
        ]);

        $label = Label::create($request->only('name'));

        return response()->json([
            'success' => 'Label created successfully.',
            'label'   => $label
        ]);
    }

    /**
     * Show the form for editing the specified label.
     */
    public function edit(Label $label)
    {
        $this->checkAdmin();
        return view('admin.labels.edit', compact('label'));
    }

    /**
     * Update the specified label in storage.
     */
    public function update(Request $request, Label $label)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:labels,name,' . $label->id,
        ]);

        $label->update($request->only('name'));

        return response()->json([
            'success' => 'Label updated successfully.',
            'label'   => $label
        ]);
    }

    /**
     * Remove the specified label from storage.
     */
    public function destroy(Label $label)
    {
        $this->checkAdmin();
        $label->delete();
        return response()->json(['success' => 'Label deleted successfully.']);
    }
}
