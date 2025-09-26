<?php

namespace App\Http\admin\Controllers;

use App\Http\admin\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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

        $roles = Role::pluck('name', 'name');

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(User $user)
    {
        $roles = Role::pluck('name', 'name'); 

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->assignRole($request->input('role'));

        $user->mediaManage($request);

        return redirect()->route('users.index')->with('success', 'Користувача створено');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name'); 
        $userRole = $user->roles->pluck('name')->first(); 

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

         $user->syncRoles($request->input('role'));

        $user->mediaManage($request);

        return redirect()->back()->with('success', 'Користувача оновлено');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Користувача видалено');
    }
}
