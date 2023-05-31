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
        $q_po = POHeadModel::whereNull('status_po')->orderby('tanggal_po', 'desc')->get();
        $data = [
            'all_po' => $q_po
        ];
        return view('po.index', $data);
    }

    public function add()
    {
        $q_supplier = SupplierModel::all();
        $data = [
            'allSupplier' => $q_supplier,
            'no_po' => $this->create_no_po()
        ];

        return view('po.add', $data);
    }

    public function store(Request $request)
    {
        try {
            $save_head = new POHeadModel();
            //store header
            $save_head->supplier_id = $request->sel_supplier;
            $save_head->nomor_po = $request->inpNomor;
            $save_head->tanggal_po = date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_po)));
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

    public function edit($id)
    {
        $q_head = POHeadModel::find($id);
        $q_supplier = SupplierModel::all();
        $data = [
            'resHead' => $q_head,
            'allSupplier' => $q_supplier
        ];
        return view('po.edit', $data);
    }

    public function update(Request $request, $id)
    {
        try {
            $update_head = POHeadModel::find($id);
            //store header
            $update_head->tanggal_po = date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_po)));
            $update_head->supplier_id = $request->sel_supplier;
            $update_head->keterangan = $request->inp_keterangan;
            $update_head->ppn_persen = $request->inputTotal_PpnPersen;
            $update_head->ppn_rupiah = str_replace(",","", $request->inputTotal_DiskRupiah);
            $update_head->diskon_persen = $request->inputKeterangan;
            $update_head->diskon_rupiah = str_replace(",","", $request->inputTotal_PpnRupiah);
            $update_head->total_po = str_replace(",","", $request->inputTotal);
            $update_head->total_po_net = str_replace(",","", $request->inputTotalNet);
            $update_head->cara_bayar = $request->inp_carabayar;
            $update_head->save();
            //store detail
            $jml_item = count($request->item_id);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    if($value['id_item'][$i]==0)
                    {
                        $newdetail = new PODetailModel();
                        $newdetail->head_id = $id;
                        $newdetail->produk_id = $value['item_id'][$i];
                        $newdetail->qty = $value['item_qty'][$i];
                        $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                        $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                        $newdetail->save();
                    } else {
                        $update_detail = PODetailModel::find($value['id_item'][$i]);
                        $update_detail->qty = $value['item_qty'][$i];
                        $update_detail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                        $update_detail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                        $update_detail->save();
                    }
                    
                }
            }
            return redirect('purchaseOrder')->with('message', 'Perubahan data PO baru berhasil');
            //store detail
        } catch (QueryException $e)
        {
            return redirect('purchaseOrder')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function delete_items(Request $request)
    {
        $id_data = $request->id_data;
        $delete = PODetailModel::find($id_data);
        $exec = $delete->delete();
        if($exec)
        {
            $response = 'true';
        } else {
            $response = 'false';
        }
        return response()->json([
            'response' => $response
        ]);
    }

    public function delete_po($id)
    {
        $po_head = POHeadModel::find($id);
        $exec_del_head = $po_head->delete();
        if($exec_del_head)
        {
            $po_detail = PODetailModel::where('head_id', $id);
            $exec_po_detail = $po_detail->delete();
            if($exec_po_detail) {
                return redirect('purchaseOrder')->with('message', 'PO berhasil dihapus');
            } else {
                return redirect('purchaseOrder')->with('message', 'PO gagal dihapus');
            }
        } else {
            return redirect('purchaseOrder')->with('message', 'PO gagal dihapus');
        }
    }

    public function approve($id)
    {
        $q_head = POHeadModel::find($id);
        $data = [
            'resHead' => $q_head
        ];
        return view('po.approve', $data);
    }

    public function approveStore(Request $request, $id)
    {
        $update_po = POHeadModel::find($id);
        $update_po->status_po = 1; //approved
        $exec = $update_po->save();
        if($exec)
        {
            return redirect('purchaseOrder')->with('message', 'Approved PO  berhasil');
        } else {
            return redirect('purchaseOrder')->with('message', 'Approved PO gagal');
        }
    }


    public function print($id)
    {
        $q_head = POHeadModel::find($id);
        // PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadview('po.print_po', [
            'resHead' => $q_head
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
        // return $pdf->download('pdfview.pdf');  
    }
}
