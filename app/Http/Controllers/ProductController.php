<?php

namespace App\Http\Controllers;

use App\Models\MerkModel;
use App\Models\ProductModel;
use App\Models\UnitModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

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
        $query_merk = MerkModel::all();
        $data['allUnit'] = $query_unit;
        $data['allMerk'] = $query_merk;
        return view('common.produk.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $new_data = new ProductModel();
            $new_data->kode = $request->inp_kode;
            $new_data->nama_produk = $request->inp_nama;
            $new_data->merk_id = $request->sel_merk;
            $new_data->unit_id = $request->sel_satuan;
            $new_data->kemasan = $request->inp_kemasan;
            $new_data->harga_toko = str_replace(",","", $request->inp_harga_toko);
            $new_data->harga_eceran = str_replace(",","", $request->inp_harga_eceran);
            $exec = $new_data->save();
            if($exec)
            {
                return redirect('stok')->with('message', 'Data berhasil disimpan');
            } else {
                return redirect('stok')->with('message', 'Data gagal disimpan');
            }
           
        } catch (QueryException $e)
        {
            return redirect('stok')->with('message', 'Proses gagal. Error : '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $query_main = ProductModel::find($id);
        $query_unit = UnitModel::all();
        $query_merk = MerkModel::all();
        $data = [
            'res' => $query_main,
            'allUnit' => $query_unit,
            'allMerk' => $query_merk
        ];
        return view('common.produk.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update = ProductModel::find($id);
            $update->kode = $request->inp_kode;
            $update->nama_produk = $request->inp_nama;
            $update->merk_id = $request->sel_merk;
            $update->unit_id = $request->sel_satuan;
            $update->kemasan = $request->inp_kemasan;
            $update->harga_toko = str_replace(",","", $request->inp_harga_toko);
            $update->harga_eceran = str_replace(",","", $request->inp_harga_eceran);
            $exec = $update->save();
            if($exec)
            {
                return redirect('stok')->with('message', 'Update data berhasil');
            } else {
                return redirect('stok')->with('message', 'Update data gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('stok')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $delete = ProductModel::find($id);
        $exec = $delete->delete();
        if($exec)
        {
            return redirect('stok')->with('message', 'Data berhasil dihapus');
        } else {
            return redirect('stok')->with('message', 'Data gagal dihapus');
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

    public function searchItemJual(Request $request)
    {
        $keyword = $request->search;
        $result = ProductModel::where('nama_produk', 'LIKE', '%'.$keyword.'%')->get();
        $response = array();
        foreach($result as $item){
            $response[] = array(
                "value"=>$item->id, 
                "label"=> "[".$item->nama_produk." | Stok : ".$item->stok_akhir." ".$item->get_unit->unit."]",
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

    //manajemen stok
    public function list_stok()
    {
        $query = ProductModel::all();
        $data['allProduct'] = $query;
        return view('manajemen_stok.daftar.index', $data);
    }

    public function setting_stok()
    {
        $query = ProductModel::all();
        $data['allProduct'] = $query;
        return view('manajemen_stok.daftar.setting', $data);
    }

    public function setting_stok_store(Request $request)
    {
        try {
            $jml_item = count($request->id_stok);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $update = ProductModel::find($value['id_stok'][$i]);
                    $update->harga_toko = str_replace(",","", $value['inp_harga_toko'][$i]);
                    $update->harga_eceran = str_replace(",","", $value['inp_harga_eceran'][$i]);
                    $update->stok_awal = str_replace(",","", $value['inp_stok_awal'][$i]);
                    $update->stok_akhir = str_replace(",","", $value['inp_stok_akhir'][$i]);
                    $update->save();
                }
            }
            return redirect('daftarStok')->with('message', 'Pengaturan data produk berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('daftarStok')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    //kartu stok
    public function kartu_stok()
    {
        return view('manajemen_stok.kartu_stok.index');
    }

    public function searchItemKartuStok(Request $request)
    {
        $keyword = $request->search;
        $result = ProductModel::where('nama_produk', 'LIKE', '%'.$keyword.'%')->get();
        $response = array();
        foreach($result as $item){
            $response[] = array(
                "value"=>$item->id, 
                "label"=> "[".$item->kode." | ".$item->nama_produk."]",
                "kode" => $item->kode,
                "nama_produk" => $item->nama_produk,
                "merk" => $item->get_merk->merk,
                "kemasan" => $item->kemasan,
                "satuan"=>$item->get_unit->unit
            );
        }
        return response()
            ->json($response)
            ->withCallback($request->input('callback'));

    }
}
