<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yoeunes\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('permissions')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.users.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'address' => 'required|string',
                'permissions' => 'nullable|array',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->has('permissions')) {
                $user->givePermissionTo($request->permissions);
            }

            Toastr::success('User created successfully.');
            return redirect()->route('users.index');

        } catch (\Exception $e) {
            Toastr::error('Failed to create user. ' . $e->getMessage());
            return redirect()->back();

        }

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();

        return view('admin.users.edit', compact('user',  'permissions'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'password' => 'sometimes|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'address' => 'required|string',
                'permissions' => 'nullable|array',
            ]);

            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
            }

            Toastr::success('User updated successfully.');
        } catch (\Exception $e) {
            Toastr::error('Failed to update user. ' . $e->getMessage());
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Toastr::success('User deleted successfully.');
        } catch (\Exception $e) {
            Toastr::error('Failed to delete user. ' . $e->getMessage());
        }

        return redirect()->route('users.index');
    }
}
