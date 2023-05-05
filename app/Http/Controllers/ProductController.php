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

    public function edit($id)
    {
        $query_main = ProductModel::find($id);
        $query_unit = UnitModel::all();
        $data = [
            'res' => $query_main,
            'allUnit' => $query_unit
        ];
        return view('common.produk.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = ProductModel::find($id);
            $update->kode = $request->inp_kode;
            $update->nama_produk = $request->inp_nama;
            $update->unit_id = $request->sel_satuan;
            $update->kemasan = $request->inp_kemasan;
            $update->harga_toko = str_replace(",","", $request->inp_harga_toko);
            $update->harga_eceran = str_replace(",","", $request->inp_harga_eceran);
            $exec = $update->save();
            if($exec)
            {
                return redirect('product')->with('message', 'Update data berhasil');
            } else {
                return redirect('product')->with('message', 'Update data gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('product')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = ProductModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('product')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('product')->with('message', 'Data gagal dihapus');
        }
    }

    public function searchItem(Request $request)
    {
        $keyword = $request->search;
        $result = ProductModel::where('nama_produk', 'LIKE', '%'.$keyword.'%')->get();
        $response = array();
        foreach($result as $item){
            $response[] = array(
                "value"=>$item->id, 
                "label"=>$item->nama_produk,
                "kode"=>$item->kode,
                "satuan"=>$item->get_unit->unit,
                "harga_toko"=>$item->harga_toko,
                "harga_eceran" => $item->harga_eceran,
                "kemasan" => $item->kemasan,
                "stok" => $item->stok_akhir
            );
        }
        return response()
            ->json($response)
            ->withCallback($request->input('callback'));

    }
}
