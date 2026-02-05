<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = app(Role::class)->paginate(10);
        $view = "Roles/Index";
        return Inertia::render($view, ['roles'=>$roles]);
    }

    public function create()
    {
        $view = "Roles/Create";

        $configPermissions = config('set-permission.permissions');

        $permissionNames = [];

        foreach ($configPermissions as $role => $modules) {
            foreach ($modules as $module => $routes) {
                foreach ($routes as $route => $label) {
                    if ($module === 'dashboards') {
                        $permissionNames[] = "{$role}.{$module}";
                    } else {
                        $action = last(explode('.', $route));
                        $permissionNames[] = "{$role}.{$module}.{$action}";
                    }
                }
            }
        }

        // Check missing permissions
        $missingCount = Permission::whereNotIn('name', $permissionNames)->count();

        // if ($missingCount > 0) {
        //     CreatePermissionJob::dispatch();
        // }

        return Inertia::render($view, [
            'list_permissions' => $configPermissions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ]);
        $role = Role::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'guard_name' => 'web'
        ]);
        // Role Admin centrol
        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }
        

        return redirect()->route('admin.roles.index');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $existingPermissions = $role->permissions->pluck('name')->toArray();
        $configPermissions = config('set-permission.permissions');
        $view = "Roles/Edit";
        return Inertia::render($view, [
            'role' => $role,
            'list_permissions' => $configPermissions,
            'existing' => $existingPermissions
        ]);
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
        ]);

        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = app(Role::class)->with('permissions')->find($id);
        $role->delete();
        return redirect()->back();
    }
}
