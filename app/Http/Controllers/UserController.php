<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mobile' => ['required', 'string', 'unique:users,mobile_number'],
            'role_ids' => ['required', 'array'],
            'role_ids.*' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile_number' => $validated['mobile'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->roles()->attach($validated['role_ids']);

        $user->forceFill([
            'email_verified_at' => now(),
            'mobile_number_verified_at' => now(),
        ])->save();

        return redirect()->route('user.index')->banner('User created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }


    public function detatchRole(User $user, Role $role)
    {
        // Do not allow users who are not admins to detatch roles
        if (!auth()->user()->hasRole('administrator')) {
            return redirect()->back()->dangerBanner('You do not have permission to do that.');
        }

        // Do not allow detatching fixed roles
        if ($role->isFixed()) {
            return redirect()->back()->dangerBanner('You cannot detatch a fixed role.');
        }
        $user->roles()->detach($role);
        return redirect()->route('user.edit', $user)->banner('Role detached');
    }

    public function attachRole(Request $request, User $user)
    {
        // Do not allow users who are not admins to attach roles
        if (!auth()->user()->hasRole('administrator')) {
            return redirect()->back()->dangerBanner('You do not have permission to do that.');
        }
        $role = Role::find($request->role_id);
        // Do not allow attaching the fixed roles
        if ($role->isFixed()) {
            return redirect()->back()->dangerBanner('You cannot attach a fixed role.');
        }
        // Do not allow attaching the same role twice
        if ($user->roles->contains($role)) {
            return redirect()->back()->dangerBanner('User already has this role');
        }
        $user->roles()->attach($role);
        return redirect()->route('user.edit', $user)->banner('Role attached');
    }

    public function resetPassword(Request $request, User $user)
    {
        // Do not allow users who are not admins to reset passwords
        if (!auth()->user()->hasRole('administrator')) {
            return redirect()->back()->dangerBanner('You do not have permission to do that.');
        }
        $request->validate([
            'confirm' => 'required|boolean',
        ]);

        if (!$request->confirm) {
            return redirect()->back()->dangerBanner('You must confirm to reset the password.');
        }

        $password = 'Password@' . now()->format('dmY');
        $user->password = bcrypt($password);
        $user->save();
        return redirect()->route('user.edit', $user)->banner('Password reset');
    }
}
