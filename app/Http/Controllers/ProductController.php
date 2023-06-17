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
use Svg\Tag\Rect;

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
        $query = ProductModel::orderby('kode', 'asc')->get();
        $data['allProduct'] = $query;
        return view('common.produk.index', $data);
    }

    public function add()
    {
        $query_unit = UnitModel::all();
        $query_merk = MerkModel::all();
        $data = [
            'allUnit' => $query_unit,
            'allMerk' => $query_merk,
            'kode_baru' => $this->create_kode_produk()
        ];
        return view('common.produk.add', $data);
    }

    public function create_kode_produk()
    {
        $sub = 1;
        $no_item = 1;
        $kd="UTB/Pupuk-";
        
        $result = ProductModel::orderby('kode', 'desc')->first();
        if(empty($result->kode)) {
            $no_baru = $kd.sprintf('%02s', $no_item).".".sprintf('%04s', $sub); 
        } else {
            $no_trans_baru = (int)substr($result->kode, 11, 2) + 1;
            $no_baru = $kd.sprintf('%02s', $no_trans_baru).".".sprintf('%04s', $sub);
        }
        return $no_baru;
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
            if(isset($request->inp_ket))
            {
                $new_data->keterangan = $request->inp_ket;
            }
            $new_data->harga_toko = 0;
            $new_data->harga_eceran = 0;
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
            $update->nama_produk = $request->inp_nama;
            $update->merk_id = $request->sel_merk;
            $update->unit_id = $request->sel_satuan;
            $update->kemasan = $request->inp_kemasan;
            $update->keterangan = $request->inp_ket;
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

    public function add_sub_produk($id)
    {
        $main = ProductModel::find($id);
        $kode_produk_head = substr($main->kode, 0, 13);
        $sub_main = \DB::table('common_product')
                                ->where(\DB::raw('SUBSTR(kode,1, 13)'), '=', $kode_produk_head)
                                ->whereNull('deleted_at')
                                ->orderby('id', 'desc')
                                ->selectRaw('kode')
                                ->first();
        $kode_produk_sub = $kode_produk_head . sprintf('%04s', (int)substr($sub_main->kode, 13, 4) + 1);
        $query_unit = UnitModel::all();
        $query_merk = MerkModel::all();
        $data = [
            'main' => $main,
            'allUnit' => $query_unit,
            'allMerk' => $query_merk,
            'kode_sub' => $kode_produk_sub
        ];
        return view('common.produk.add_sub', $data);
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
                "harga_beli" => $item->harga_beli,
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
                "label"=> "[".$item->kode." | ".$item->nama_produk." | Stok : ".$item->stok_akhir." ".$item->get_unit->unit."]",
                "kode"=>$item->kode,
                "satuan"=>$item->get_unit->unit,
                "harga_toko"=>$item->harga_toko,
                "harga_eceran" => $item->harga_eceran,
                "harga_beli" => $item->harga_beli,
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
                    $update->harga_beli = str_replace(",","", $value['inp_harga_beli'][$i]);
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
    public function kartu_stok_filter(Request $request)
    {
        $id_stok = $request->id_stok;
        $tgl_1 = $request->tgl_1;
        $tgl_2 = $request->tgl_2;
        $ket_periode = "PERIODE : ".$request->ket_periode;
        $result = ProductModel::find($id_stok);
        $qty_awal = $result->stok_awal;
        //+
        $qty_pembelian_awal = \DB::table('receive_head')
                            ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                            ->whereDate('receive_head.tanggal_receive', '<', $tgl_1)
                            ->where('receive_detail.produk_id', $id_stok)
                            ->whereNull('receive_head.deleted_at')
                            ->selectRaw('sum(receive_detail.qty) as t_pembelian_awal')
                            ->pluck('t_pembelian_awal')->first();
        $qty_return_jual_awal = \DB::table('return_jual_head')
                            ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                            ->whereDate('return_jual_head.tgl_return', '<', $tgl_1)
                            ->where('return_jual_detail.produk_id', $id_stok)
                            ->whereNull('return_jual_head.deleted_at')
                            ->selectRaw('sum(return_jual_detail.qty) as t_return_jual_awal')
                            ->pluck('t_return_jual_awal')->first();

        //-
        $qty_penjualan_awal = \DB::table('jual_head')
                            ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                            ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                            ->where('jual_detail.produk_id', $id_stok)
                            ->whereNull('jual_head.deleted_at')
                            ->whereNULL('jual_head.jenis_jual')
                            ->where('jual_head.status_approval', 1)
                            ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                            ->pluck('t_penjualan_awal')->first();
        $qty_return_beli_awal = \DB::table('return_beli_head')
                            ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                            ->whereDate('return_beli_head.tgl_return', '<', $tgl_1)
                            ->where('return_beli_detail.produk_id', $id_stok)
                            ->whereNull('return_beli_head.deleted_at')
                            ->selectRaw('sum(return_beli_detail.qty) as t_return_beli_awal')
                            ->pluck('t_return_beli_awal')->first();

        $qty_pemberian_sampel = \DB::table('jual_head')
                            ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                            ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                            ->where('jual_detail.produk_id', $id_stok)
                            ->whereNull('jual_head.deleted_at')
                            ->where('jual_head.jenis_jual', 1)
                            ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                            ->pluck('t_penjualan_awal')->first();

        $stok_awal = ($qty_awal + $qty_pembelian_awal + $qty_return_jual_awal) - ($qty_penjualan_awal + $qty_return_beli_awal + $qty_pemberian_sampel);

        //range date selected
        //stok masuk
        $qty_pembelian = \DB::table('receive_head')
                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                ->whereDate('receive_head.tanggal_receive', '>=', $tgl_1)
                ->whereDate('receive_head.tanggal_receive', '<=', $tgl_2)
                ->where('receive_detail.produk_id', $id_stok)
                ->whereNull('receive_head.deleted_at')
                ->selectRaw('sum(receive_detail.qty) as t_pembelian')
                ->pluck('t_pembelian')->first();
        $qty_return_jual = \DB::table('return_jual_head')
                ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                ->whereDate('return_jual_head.tgl_return', '>=', $tgl_1)
                ->whereDate('return_jual_head.tgl_return', '<=', $tgl_2)
                ->where('return_jual_detail.produk_id', $id_stok)
                ->whereNull('return_jual_head.deleted_at')
                ->selectRaw('sum(return_jual_detail.qty) as t_return_jual')
                ->pluck('t_return_jual')->first();
        //stok keluar
        $qty_penjualan = \DB::table('jual_head')
                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                ->where('jual_detail.produk_id', $id_stok)
                ->whereNull('jual_head.deleted_at')
                ->whereNull('jual_head.jenis_jual')
                ->where('jual_head.status_approval', 1)
                ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                ->pluck('t_penjualan')->first();
        $qty_pemberian_sampel = \DB::table('jual_head')
                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                ->where('jual_detail.produk_id', $id_stok)
                ->whereNull('jual_head.deleted_at')
                ->where('jual_head.jenis_jual', 1)
                ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                ->pluck('t_penjualan')->first();
        $qty_return_beli = \DB::table('return_beli_head')
                ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                ->whereDate('return_beli_head.tgl_return', '>=', $tgl_1)
                ->whereDate('return_beli_head.tgl_return', '<=', $tgl_2)
                ->where('return_beli_detail.produk_id', $id_stok)
                ->whereNull('return_beli_head.deleted_at')
                ->selectRaw('sum(return_beli_detail.qty) as t_return_beli')
                ->pluck('t_return_beli')->first();
        //rincian
        //masuk
        $rincian_pembelian = \DB::table('receive_head')
                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                ->whereDate('receive_head.tanggal_receive', '>=', $tgl_1)
                ->whereDate('receive_head.tanggal_receive', '<=', $tgl_2)
                ->where('receive_detail.produk_id', $id_stok)
                ->whereNull('receive_head.deleted_at')
                ->get();
        $rincian_return_jual = \DB::table('return_jual_head')
                ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                ->whereDate('return_jual_head.tgl_return', '>=', $tgl_1)
                ->whereDate('return_jual_head.tgl_return', '<=', $tgl_2)
                ->where('return_jual_detail.produk_id', $id_stok)
                ->whereNull('return_jual_head.deleted_at')
                ->get();
        //keluar
        $rincian_penjualan = \DB::table('jual_head')
                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                ->where('jual_detail.produk_id', $id_stok)
                ->whereNull('jual_head.deleted_at')
                ->whereNull('jual_head.jenis_jual')
                ->where('jual_head.status_approval', 1)
                ->get();
        $rincian_return_beli = \DB::table('return_beli_head')
                ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                ->whereDate('return_beli_head.tgl_return', '>=', $tgl_1)
                ->whereDate('return_beli_head.tgl_return', '<=', $tgl_2)
                ->where('return_beli_detail.produk_id', $id_stok)
                ->whereNull('return_beli_head.deleted_at')
                ->get();
        $rincian_pemberian_sampel = \DB::table('jual_head')
                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                ->where('jual_detail.produk_id', $id_stok)
                ->whereNull('jual_head.deleted_at')
                ->where('jual_head.jenis_jual', 1)
                ->get();
        //summary
        $stok_masuk = $qty_pembelian + $qty_return_jual;
        $stok_keluar = $qty_penjualan + $qty_return_beli + $qty_pemberian_sampel;
        //stok akhir
        $current_qty = ($stok_awal + $stok_masuk) - $stok_keluar;
        return response()
            ->json([
                'periode' => $ket_periode,
                'stok_awal' => (!empty($stok_awal)) ? $stok_awal : 0,
                'stok_masuk' => (!empty($stok_masuk)) ? $stok_masuk : 0,
                'stok_keluar' => (!empty($stok_keluar)) ? $stok_keluar : 0,
                'stok_akhir' => (!empty($current_qty)) ? $current_qty : 0,
                'rincian_beli' => $rincian_pembelian,
                'rincian_return_jual' => $rincian_return_jual,
                'rincian_jual' => $rincian_penjualan,
                'rincian_return_beli' => $rincian_return_beli,
                'rincian_sampel' => $rincian_pemberian_sampel
            ]);
    }

    //pemberian sampel
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
            $save_head->tgl_transaksi = ($request->inp_tgl_pemberian=="") ? $this->datetimeStore : date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_pemberian)));
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
                    $newdetail->qty = str_replace(",","", $value['item_qty'][$i]);
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
        $kd="SPL";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = JualHeadModel::orderby('id', 'desc')->first();
        if(empty($result->no_invoice)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->no_invoice, 10, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

}
