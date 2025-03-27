<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Traits\AdminCheck;

class UserController extends Controller
{
    /**
     * Inline role check method.
     */
    use AdminCheck;

    /**
     * Display a listing of the users using UsersDataTable.
     */
    public function index(UsersDataTable $dataTable)
    {
        $this->checkAdmin();
        return $dataTable->render(view: 'admin.users.index');
    }


    /**
     * Show the form for editing the specified user's role.
     */
    public function edit(User $user)
    {
        $this->checkAdmin();
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->checkAdmin();
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);
        $user->syncRoles([$request->role]);
        return response()->json([
            'success' => 'User role updated successfully!',
            'user'    => $user,
        ]);
    }

    /**
     * Optionally, delete the specified user.
     */
    public function destroy(User $user)
    {
        $this->checkAdmin();
        $user->delete();
        return response()->json(['success' => 'User deleted successfully!']);
    }
}
