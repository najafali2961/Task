<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Models\Category;
use App\Traits\AdminCheck;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Helper method to ensure the authenticated user is an Administrator.
     */
    use AdminCheck;

    /**
     * Display a listing of the categories using CategoriesDataTable.
     */
    public function index(CategoriesDataTable $dataTable)
    {
        $this->checkAdmin();
        return $dataTable->render('admin.categories.index');
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $this->checkAdmin();
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        $category = Category::create($request->only('name'));

        return response()->json([
            'success'  => 'Category created successfully.',
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $this->checkAdmin();
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->only('name'));

        return response()->json([
            'success'  => 'Category updated successfully.',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $this->checkAdmin();
        $category->delete();
        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
