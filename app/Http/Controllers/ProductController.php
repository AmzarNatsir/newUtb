<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\MerkModel;
use App\Models\ProductModel;
use App\Models\UnitModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class ProductController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
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

    public function pemberian_sampel()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('manajemen_stok.pemberian_sampel.index', $data);
    }

    public function pemberian_sampel_store(Request $request)
    {
        try {
            $save_head = new JualHeadModel();
            //store header
            $save_head->customer_id = $request->sel_customer;
            $save_head->no_invoice = $this->create_no_invoice();
            $save_head->tgl_invoice = ($request->inp_tgl_pemberian=="") ? $this->datetimeStore : date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_pemberian)));
            $save_head->keterangan = $request->inp_keterangan;
            $save_head->total_invoice = 0;
            $save_head->ppn_persen = 0;
            $save_head->ppn_rupiah = 0;
            $save_head->diskon_persen = 0;
            $save_head->diskon_rupiah = 0;
            $save_head->ongkir = 0;
            $save_head->total_invoice_net = 0;
            $save_head->jenis_jual = 1; //pemberian sampel
            $save_head->user_id = auth()->user()->id;
            $save_head->save();
            $id_head = $save_head->id;
            //store detail
            $jml_item = count($request->item_id);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $newdetail = new JualDetailModel();
                    $newdetail->head_id = $id_head;
                    $newdetail->produk_id = $value['item_id'][$i];
                    $newdetail->qty = $value['item_qty'][$i];
                    $newdetail->harga = 0;
                    $newdetail->diskitem_persen =0;
                    $newdetail->diskitem_rupiah = 0;
                    $newdetail->sub_total = 0;
                    $newdetail->sub_total_net = 0;
                    $newdetail->save();
                    //Update Stok
                    $update = ProductModel::find($value['item_id'][$i]);
                    $update->stok_akhir = ((int)$update->stok_akhir -  (int)str_replace(",","", $value['item_qty'][$i]));
                    $update->save();
                }
            }
            if($id_head)
            {
                return redirect('pemberianSampel')->with('message', 'Transaksi berhasil disimpan');
            } else {
                return redirect('pemberianSampel')->with('message', 'Transaksi gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('pemberianSampel')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_invoice()
    {
        $no_urut = 1;
        $kd="INV";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = JualHeadModel::whereYear('tgl_invoice', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_invoice)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->no_invoice, 10, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

}
