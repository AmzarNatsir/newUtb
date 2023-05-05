<?php

namespace App\Http\Controllers;

use App\Models\PODetailModel;
use App\Models\POHeadModel;
use App\Models\SupplierModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDF;

class POController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
    }

    public function index()
    {
        $q_po = POHeadModel::orderby('tanggal_po', 'desc')->get();
        $data = [
            'all_po' => $q_po
        ];
        return view('po.index', $data);
    }

    public function add()
    {
        $q_supplier = SupplierModel::all();
        $data = [
            'allSupplier' => $q_supplier
        ];

        return view('po.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $save_head = new POHeadModel();
            //store header
            $save_head->supplier_id = $request->sel_supplier;
            $save_head->nomor_po = $this->create_no_po();
            $save_head->tanggal_po = $this->datetimeStore;
            $save_head->keterangan = $request->inp_keterangan;
            $save_head->ppn_persen = $request->inputTotal_PpnPersen;
            $save_head->ppn_rupiah = str_replace(",","", $request->inputTotal_DiskRupiah);
            $save_head->diskon_persen = $request->inputKeterangan;
            $save_head->diskon_rupiah = str_replace(",","", $request->inputTotal_PpnRupiah);
            $save_head->total_po = str_replace(",","", $request->inputTotal);
            $save_head->total_po_net = str_replace(",","", $request->inputTotalNet);
            $save_head->cara_bayar = $request->inp_carabayar;
            $save_head->user_id = auth()->user()->id;
            $save_head->save();
            $id_head = $save_head->id;
            //store detail
            $jml_item = count($request->item_id);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    $newdetail = new PODetailModel();
                    $newdetail->head_id = $id_head;
                    $newdetail->produk_id = $value['item_id'][$i];
                    $newdetail->qty = $value['item_qty'][$i];
                    $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                    $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                    $newdetail->save();
                }
            }
            if($id_head)
            {
                return redirect('purchaseOrder')->with('message', 'Pembuatan PO baru berhasil');
            } else {
                return redirect('purchaseOrder')->with('message', 'Pembuatan PO baru gagal');
            }
            //store detail
        } catch (QueryException $e)
        {
            return redirect('purchaseOrder')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_po()
    {
        $no_urut = 1;
        $kd="PO";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = POHeadModel::whereYear('tanggal_po', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->nomor_po)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = substr($result->nomor_po, 9, 4)+1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

    public function approve($id)
    {
        $q_head = POHeadModel::find($id);
        $data = [
            'resHead' => $q_head
        ];
        return view('po.approve', $data);
    }


    public function print($id)
    {
        $q_head = POHeadModel::find($id);
        $pdf = PDF::loadview('po.print_po', [
            'resHead' => $q_head
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }
}
