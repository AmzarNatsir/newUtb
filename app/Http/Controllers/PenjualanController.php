<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\ProductModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDF;

class PenjualanController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
    }

    public function index()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('penjualan.index', $data);
    }

    public function store(Request $request)
    {
        try {
            $save_head = new JualHeadModel();
            //store header
            $save_head->customer_id = $request->sel_customer;
            $save_head->no_invoice = $this->create_no_invoice();
            $save_head->tgl_invoice = $this->datetimeStore;
            $save_head->keterangan = $request->inp_keterangan;
            $save_head->bayar_via = $request->inp_carabayar;
            if($request->inpTglJatuhTempo <> "")
            {
                $newDate_jtp = date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglJatuhTempo)));  
            } else {
                $newDate_jtp = NULL;
            }
            $save_head->tgl_jatuh_tempo = $newDate_jtp;
            $save_head->total_invoice = str_replace(",","", $request->inputTotal);
            $save_head->ppn_persen = $request->inputTotal_PpnPersen;
            $save_head->ppn_rupiah = str_replace(",","", $request->inputTotal_DiskRupiah);
            $save_head->diskon_persen = $request->inputTotal_DiskPersen;
            $save_head->diskon_rupiah = str_replace(",","", $request->inputTotal_PpnRupiah);
            $save_head->ongkir = str_replace(",","", $request->inputOngkosKirim);
            $save_head->total_invoice_net = str_replace(",","", $request->inputTotalNet);
            if($request->inp_carabayar==2) //Credit
            {
                $save_head->status_invoice = 2; //Belum Lunas
            } else {
                $save_head->status_invoice = 1; //Lunas
            }
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
                    $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                    $newdetail->diskitem_persen = $value['item_diskon'][$i];
                    $newdetail->diskitem_rupiah = str_replace(",","", $value['item_diskonrp'][$i]);
                    $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                    $newdetail->sub_total_net = str_replace(",","", $value['item_sub_total_net'][$i]);
                    $newdetail->save();
                    //Update Stok
                    // $update = ProductModel::find($value['item_id'][$i]);
                    // $update->stok_akhir = ((int)$update->stok_akhir -  (int)str_replace(",","", $value['item_qty'][$i]));
                    // $update->save();
                }
            }
            if($id_head)
            {
                return redirect('penjualan')->with('message', 'Transaksi berhasil disimpan');
            } else {
                return redirect('penjualan')->with('message', 'Transaksi gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('penjualan')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
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

    public function print_invoice($id)
    {
        $data['dt_head'] = JualHeadModel::find($id);
        // $data['dt_detail'] = JualDetailModel::where('head_id', $id)->get();
        $pdf = PDF::loadview('penjualan.print_invoice', [
            'dt_head' => JualHeadModel::find($id)
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();

        // return view('penjualan.print_invoice', $data);
    }

}
