<?php

namespace App\Http\Controllers;

use App\Models\POHeadModel;
use App\Models\ProductModel;
use App\Models\ReceiveDetailModel;
use App\Models\ReceiveHeadModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
    }

    public function index()
    {
        $q_po = POHeadModel::where('status_po', 1)->orderby('tanggal_po', 'desc')->get();
        $data = [
            'all_po' => $q_po
        ];
        return view('receiving.index', $data);
    }

    public function add($id)
    {
        $q_head = POHeadModel::find($id);
        $data = [
            'resHead' => $q_head
        ];
        return view('receiving.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $save_head = new ReceiveHeadModel();
            //store header
            $save_head->po_id = $request->inp_id_po;
            $save_head->supplier_id = $request->sel_supplier;
            $save_head->nomor_receive = $this->create_no_receive();
            $save_head->tanggal_receive = $this->datetimeStore;
            $save_head->no_invoice = $request->inp_no_invoice;
            $save_head->tgl_invoice = ($request->inp_tgl_invoice=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_invoice)));
            $save_head->tgl_jatuh_tempo = ($request->cara_bayar==1) ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_jatuh_tempo)));
            $save_head->keterangan = $request->inp_keterangan;
            $save_head->ppn_persen = $request->inputTotal_PpnPersen;
            $save_head->ppn_rupiah = str_replace(",","", $request->inputTotal_DiskRupiah);
            $save_head->diskon_persen = $request->inputTotal_DiskPersen;;
            $save_head->diskon_rupiah = str_replace(",","", $request->inputTotal_PpnRupiah);
            $save_head->total_receice = str_replace(",","", $request->inputTotal);
            $save_head->total_receive_net = str_replace(",","", $request->inputTotalNet);
            $save_head->cara_bayar = $request->inp_carabayar;
            $save_head->user_id = auth()->user()->id;
            $save_head->invoice_kontainer = $request->inp_invoice_kontainer;
            $save_head->nilai_kontainer = str_replace(",","", $request->inp_ongkir_kontainer);
            $save_head->tgl_tiba = ($request->inpTglTiba=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglTiba)));
            $save_head->save();
            $id_head = $save_head->id;
            //store detail
            $jml_item = count($request->item_id);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $newdetail = new ReceiveDetailModel();
                    $newdetail->head_id = $id_head;
                    $newdetail->produk_id = $value['produk_id'][$i];
                    $newdetail->qty = $value['item_qty'][$i];
                    $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                    $newdetail->diskitem_persen = $value['item_diskon'][$i];
                    $newdetail->diskitem_rupiah = str_replace(",","", $value['item_diskonrp'][$i]);
                    $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                    $newdetail->sub_total_net = str_replace(",","", $value['item_sub_total_net'][$i]);
                    $newdetail->save();
                    //Update Stok
                    $update = ProductModel::find($value['produk_id'][$i]);
                    $update->stok_akhir = ((int)$update->stok_akhir +  (int)str_replace(",","", $value['item_qty'][$i]));
                    $update->harga_toko = str_replace(",","", $value['harga_satuan'][$i]);
                    $update->save();
                }
            }
            $update_po = POHeadModel::find($request->inp_id_po);
            $update_po->status_po = 2; //Received/Close
            $update_po->save();
            if($id_head)
            {
                return redirect('receiving')->with('message', 'Proses Receive PO berhasil');
            } else {
                return redirect('receiving')->with('message', 'Proses Receive PO gagal');
            }
        } catch (QueryException $e)
        {
            return redirect('receiving')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_receive()
    {
        $no_urut = 1;
        $kd="RV";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = ReceiveHeadModel::whereYear('tanggal_receive', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->nomor_receive)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->nomor_receive, 9, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }
}
