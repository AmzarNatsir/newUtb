<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\ReceiveHeadModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //return pembeliam
    public function return_pembelian()
    {
        $data = [
            'allSupplier' => SupplierModel::all()
        ];
        return view('return.pembelian.index', $data);
    }

    public function filter_invoice_pembelian($id_supplier)
    {
        $result = ReceiveHeadModel::where('supplier_id', $id_supplier)->orderby('tanggal_receive', 'desc')->get();
        $data = [
            'list_invoice' => $result
        ];
        return view('return.pembelian.daftar_invoice', $data);
    }

    public function filter_invoice_pembelian_detail($id_invoice)
    {
        $data = [
            'dtHead' => ReceiveHeadModel::find($id_invoice)
        ];
        return view('return.pembelian.detail_invoice', $data);
    }

    //return penjualan
    public function return_penjualan()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('return.penjualan.index', $data);
    }
}
