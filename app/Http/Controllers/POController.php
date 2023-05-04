<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;

class POController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('po.index');
    }

    public function add()
    {
        $q_supplier = SupplierModel::all();
        $data = [
            'allSupplier' => $q_supplier
        ];

        return view('po.add', $data);
    }
}
