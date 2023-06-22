<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);
        $request['name'] = strtolower($request->name);
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission_ids.*' => 'required|exists:permissions,id'
        ]);

        $role = Role::firstOrCreate([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $role->permissions()->attach($request->permission_ids);

        return redirect()->route('role.index')->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }

    public function detatchPermission(Role $role, Permission $permission)
    {
        // Do not allow users who are not admins to detatch permissions
        if (!auth()->user()->hasRole('administrator')) {
            return redirect()->back()->dangerBanner('You do not have permission to do that.');
        }

        // Prevent modification of fixed roles
        if ($role->isFixed()) {
            return redirect()->back()->dangerBanner('You cannot modify fixed roles.');
        }

        $role->revokePermissionTo($permission->name);
        return redirect()->route('role.edit', $role)->banner('Permission detatched.');
    }

    public function attachPermission(Request $request, Role $role)
    {
        // Do not allow users who are not admins to attach roles
        if (!auth()->user()->hasRole('administrator')) {
            return redirect()->back()->dangerBanner('You do not have permission to do that.');
        }

        // Prevent modification of fixed roles
        if ($role->isFixed()) {
            return redirect()->back()->dangerBanner('You cannot modify fixed roles.');
        }

        $permission = Permission::find($request->permission_id);
        // Do not allow attaching the same permission twice
        if ($role->hasPermissionTo($permission->name)) {
            return redirect()->back()->dangerBanner('That permission is already attached to this role.');
        }

        $role->givePermissionTo($permission->name);
        return redirect()->route('role.edit', $role)->banner('Permission attached.');
    }
}
