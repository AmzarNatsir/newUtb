<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
        return view('manajemen_users.roles_permission.index');
    }

    public function roles_permission_add()
    {
        return view('manajemen_users.roles_permission.add');
    }
}
