<?php

namespace App\Http\Controllers;

// use App\Helpers\Helper;
use Illuminate\Http\Request;

class DashbaordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $data = [
        //     'hari_ini' => Helper::getHariIndonesia(date('D')),
        //     'bulan_ini' => Helper::getBulanIndonesia(date('m'))
        // ];
        return view('dashboard.index');
    }
}
