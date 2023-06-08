<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class DashbaordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Helper::getUser(1);
        // $data = [
        //     'hari_ini' => AllHelper::getUser(1)
        // ];
        return view('dashboard.index');
    }

    public function show_qr()
    {
        return view('dashboard.qrcode');
    }
}
