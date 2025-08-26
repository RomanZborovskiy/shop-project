<?php

namespace App\Http\admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{   
    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'roles',
            'registered_at',
            'sort_by',
            'direction',
        ]);
        
        $users = User::with('roles')->filter($filters)->paginate(10);

        $roles = Role::pluck('name', 'name');;

        return view('admin.roles.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id'); 
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id']
        ]);

        $role = Role::findById($validated['role_id']);
        $user->syncRoles([$role->name]);

        return redirect()->route('roles.index')->with('success', 'Роль оновлено');
    }

}
