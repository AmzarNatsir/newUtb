<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query_user = User::all();
        $data = [
            'all_users' => $query_user
        ];
        return view('manajemen_users.users.index', $data);
    }

    //roles

    public function roles_permission()
    {
        $data = [
            "all_roles" => Role::all()
        ];
        return view('manajemen_users.roles_permission.index', $data);
    }

    public function roles_permission_add()
    {
        return view('manajemen_users.roles_permission.add');
    }

    public function roles_permission_store(Request $request)
    {
        $role = Role::create(['name' => $request->inpNamaRole]);
        $permission = $role->syncPermissions($request->checkMenu);
        if($permission)
        {
            return redirect('roles_permission')->with('message', 'Role has created');
        } else {
            return redirect('roles_permission')->with('message', 'Fail');
        }
    }

    public function roles_permission_edit($id)
    {
        $role = Role::find($id);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $data = [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ];
        return view('manajemen_users.roles_permission.edit', $data);
    }

    public function roles_permission_update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->inpNamaRole;
        $role->save();
        $permission = $role->syncPermissions($request->checkMenu);
        if($permission)
        {
            return redirect('roles_permission')->with('message', 'Role has update');
        } else {
            return redirect('roles_permission')->with('message', 'Fail');
        }

    }

    public function roles_permission_delete($id)
    {
        $role = Role::find($id);
        $delete_role = $role->delete();
        if($delete_role)
        {
            return redirect('roles_permission')->with('message', 'Role has delete');
        } else {
            return redirect('roles_permission')->with('message', 'Fail');
        }
    }
}
