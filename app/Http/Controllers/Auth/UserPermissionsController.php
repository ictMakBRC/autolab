<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserPermissionsController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = config('laratrust.models.permission');
    }

    public function index()
    {
        return View::make('super-admin.userPermissions', ['permissions' => $this->permissionModel::latest()->get()]);
    }

    // public function create()
    // {
    //     return View::make('laratrust::panel.edit', [
    //         'model' => null,
    //         'permissions' => null,
    //         'type' => 'permission',
    //     ]);
    // }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission = $this->permissionModel::create($data);

        return redirect(route('user-permissions.index'))->with('success', 'Permission created successfully!');
    }

    public function edit($id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        return View::make('super-admin.editRolePermission', [
            'model' => $permission,
            'type' => 'permission',
        ]);
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($data);

        return redirect(route('user-permissions.index'))->with('success', 'Permission updated successfully!');
    }
}
