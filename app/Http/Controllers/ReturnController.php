<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\ReceiveHeadModel;
use App\Models\ReturnBeliDetailModel;
use App\Models\ReturnBeliHeadModel;
use App\Models\SupplierModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
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

    public function return_pembelian_store(Request $request)
    {
        try {
            
            $save_head = new ReturnBeliHeadModel();
            //store header
            $save_head->no_return = $this->create_no_return_beli();
            $save_head->receive_id = $request->inpReceiveId;
            $save_head->tgl_return = ($request->inpTglReturn=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglReturn)));
            $save_head->total_return = str_replace(",","", $request->inputTotal);
            $save_head->keterangan = $request->inpKeterangan;
            $save_head->user_id = auth()->user()->id;
            $save_head->save();
            $id_head = $save_head->id;
            //store detail
            $jml_item = count($request->item_id);
            foreach(array($request) as $key => $value)
            {
                for($i=0; $i<$jml_item; $i++)
                {
                    if($value['selectItem'][$i]=="1")
                    {
                        $newdetail = new ReturnBeliDetailModel();
                        $newdetail->head_id = $id_head;
                        $newdetail->produk_id = $value['item_id'][$i];
                        $newdetail->qty = $value['item_qty'][$i];
                        $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                        $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                        $newdetail->save();
                        //Update Stok
                        $update = ProductModel::find($value['item_id'][$i]);
                        $update->stok_akhir = ((int)$update->stok_akhir -  (int)str_replace(",","", $value['item_qty'][$i]));
                        $update->save();
                    }
                }
            }
            if($id_head)
            {
                return redirect('returnPembelian')->with('message', 'Return Pembelian Berhasil Disimpan');
            } else {
                return redirect('returnPembelian')->with('message', 'Return Pembelian Gagal Disimpan');
            }
            
        } catch (QueryException $e)
        {
            return redirect('returnPembelian')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_return_beli()
    {
        $no_urut = 1;
        $kd="RTB";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = ReturnBeliHeadModel::whereYear('tgl_return', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_return)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->no_return, 10, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
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
