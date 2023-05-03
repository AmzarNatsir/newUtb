<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\UnitModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = ProductModel::all();
        $data['allProduct'] = $query;
        return view('common.produk.index', $data);
    }

    public function add()
    {
        $query_unit = UnitModel::all();
        $data['allUnit'] = $query_unit;
        return view('common.produk.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $new_data = new ProductModel();
            $new_data->kode = $request->inp_kode;
            $new_data->nama_produk = $request->inp_nama;
            $new_data->unit_id = $request->sel_satuan;
            $new_data->kemasan = $request->inp_kemasan;
            $new_data->harga_toko = str_replace(",","", $request->inp_harga_toko);
            $new_data->harga_eceran = str_replace(",","", $request->inp_harga_eceran);
            $exec = $new_data->save();
            if($exec)
            {
                return redirect('product')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('product')->with('message', 'Data gagal disimpan');
            }
           
        } catch (QueryException $e)
        {
            return redirect('product')->with('message', 'Proses gagal. Error : '.$e->getMessage());
        }
    }
}
