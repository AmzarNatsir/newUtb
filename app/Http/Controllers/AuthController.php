<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showFormLogin()
    {
        // if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
        //     return redirect('/home');
        // }
        return redirect()->route('/');
        // return view('auth.login');
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('/');

        // $msg = [
        //     'success' => true,
        //     'message' => 'Logout successfully!'
        // ];

        // return response()->json($msg);
    }
}
