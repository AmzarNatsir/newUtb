<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query_user = User::whereNull('isUser')->get();
        $data = [
            'all_users' => $query_user
        ];
        return view('manajemen_users.users.index', $data);
    }

    public function users_add()
    {
        $data = [
            'allRole' => Role::all()
        ];
        return view('manajemen_users.users.add', $data);
    }

    public function users_store(Request $request)
    {
        if($request->selApprover=='y')
        {
            $approver = $request->selApprover;
            $lvl_approver = $request->selLevelApprover;
        } else {
            $approver = NULL;
            $lvl_approver = NULL;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'active' => 'y',
            'approver' => $approver,
            'lvl_approver' => $lvl_approver,
            'isUser' => 1
        ]);

        $excec_role_user = $user->assignRole($request->checkRole);
        if($excec_role_user)
        {
            return redirect('users')->with('message', 'User baru berhasil dibuat');
        } else {
            return redirect('users')->with('message', 'User baru gagal dibuat');
        }
    }

    public function users_edit($id)
    {
        $data = [
            'user' => User::find($id),
            'allRole' => Role::all()
        ];
        return view('manajemen_users.users.edit', $data);
    }

    public function users_update(Request $request, $id)
    {
        $update = User::find($id);
        $update->name = $request->editName;
        $update->email = $request->editEmail;
        if(!empty($request->editPassword))
        {
            $update->password =  Hash::make($request->editPassword);
        }
        if($request->selApprover=='y')
        {
            $update->approver = $request->selApprover;
            $update->lvl_approver = $request->selLevelApprover;
        } else {
            $update->approver = NULL;
            $update->lvl_approver = NULL;
        }
        if($request->selActive=='y')
        {
            $update->active = "y";
        }
        $update->save();
        \DB::table('model_has_roles')->where('model_id',$id)->delete();

        $excec_role_user = $update->assignRole($request->checkRole);
        if($excec_role_user)
        {
            return redirect('users')->with('message', 'perubahan data user berhasil disimpan');
        } else {
            return redirect('users')->with('message', 'perubahan data user gagal disimpan');
        }

    }

    public function users_delete($id)
    {
        $delete_user = User::find($id);
        $delete_user->active = "t";
        $exec_del = $delete_user->save();
        if($exec_del)
        {
            return redirect('users')->with('message', 'Data user berhasil dihapus');
        } else {
            return redirect('users')->with('message', 'Data user gagal dihapus');
        }
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

    public function get_role_permission($role)
    {
        $role = Role::find($role);
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $data = [
            'rolePermissions' => $rolePermissions
        ];
        return view('manajemen_users.roles_permission.detail_permission', $data);
    }
}
