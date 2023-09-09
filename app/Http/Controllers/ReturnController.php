<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\ProductModel;
use App\Models\ReceiveDetailModel;
use App\Models\ReceiveHeadModel;
use App\Models\ReturnBeliDetailModel;
use App\Models\ReturnBeliHeadModel;
use App\Models\ReturnJualDetailModel;
use App\Models\ReturnJualHeadModel;
use App\Models\ReturnPemberianSampleDetailModel;
use App\Models\ReturnPemberianSampleHeadModel;
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

    public function search_invoice_pembelian(Request $request)
    {

        $keyword = $request->search;
        $result = ReceiveHeadModel::where('nomor_receive', $keyword)->first();
        if(empty($result->id))
        {
            $response = [
                'success' => 'false',
                'message' => 'Nomor Invoice Tidak Ditemukan',
                'data' => ''
            ];
        } else {
            $response = [
                'success' => 'true',
                'message' => 'Nomor Invoice Ditemukan. Melanjutkan ke Form Return ?',
                'data' => $result
            ];
        }
        return response()
            ->json($response)
            ->withCallback($request->input('callback'));
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
                        $newdetail->qty = str_replace(",","", $value['qty_return'][$i]);
                        $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                        $newdetail->sub_total = str_replace(",","", $value['return_sub_total'][$i]);
                        $newdetail->save();
                        //update invoice
                        $update_invoice = ReceiveDetailModel::find($value['id_detail'][$i]);
                        $update_invoice->qty_return = ((int)$update_invoice->qty_return + (int)str_replace(",","", $value['qty_return'][$i]));
                        $update_invoice->save();
                        //Update Stok
                        $update = ProductModel::find($value['item_id'][$i]);
                        $update->stok_akhir = ((int)$update->stok_akhir -  (int)str_replace(",","", $value['qty_return'][$i]));
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

    public function search_invoice_penjualan(Request $request)
    {

        $keyword = $request->search;
        $result = JualHeadModel::where('no_invoice', $keyword)->whereNull('jenis_jual')->first();
        if(empty($result->id))
        {
            $response = [
                'success' => 'false',
                'message' => 'Nomor Invoice Tidak Ditemukan',
                'data' => ''
            ];
        } else {
            $response = [
                'success' => 'true',
                'message' => 'Nomor Invoice Ditemukan. Melanjutkan ke Form Return ?',
                'data' => $result
            ];
        }
        return response()
            ->json($response)
            ->withCallback($request->input('callback'));
    }

    public function filter_invoice_penjualan($id_customer)
    {
        $result = JualHeadModel::where('customer_id', $id_customer)->whereNull('jenis_jual')->orderby('tgl_invoice', 'desc')->get();
        $data = [
            'list_invoice' => $result
        ];
        return view('return.penjualan.daftar_invoice', $data);
    }

    public function filter_invoice_penjualan_detail($id_invoice)
    {
        $data = [
            'dtHead' => JualHeadModel::find($id_invoice)
        ];
        return view('return.penjualan.detail_invoice', $data);
    }

    public function return_penjualan_store(Request $request)
    {
        try {

            $save_head = new ReturnJualHeadModel();
            //store header
            $save_head->no_return = $this->create_no_return_jual();
            $save_head->jual_id = $request->inpInvoiceId;
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
                        $newdetail = new ReturnJualDetailModel();
                        $newdetail->head_id = $id_head;
                        $newdetail->produk_id = $value['item_id'][$i];
                        $newdetail->qty = str_replace(",","", $value['item_qty'][$i]);
                        $newdetail->harga = str_replace(",","", $value['harga_satuan'][$i]);
                        $newdetail->sub_total = str_replace(",","", $value['item_sub_total'][$i]);
                        $newdetail->save();
                        //Update Stok
                        $update = ProductModel::find($value['item_id'][$i]);
                        $update->stok_akhir = ((int)$update->stok_akhir +  (int)str_replace(",","", $value['item_qty'][$i]));
                        $update->save();
                    }
                }
            }
            if($id_head)
            {
                return redirect('returnPenjualan')->with('message', 'Return Penjualan Berhasil Disimpan');
            } else {
                return redirect('returnPenjualan')->with('message', 'Return Penjualan Gagal Disimpan');
            }

        } catch (QueryException $e)
        {
            return redirect('returnPenjualan')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_return_jual()
    {
        $no_urut = 1;
        $kd="RTJ"; //Return Jual
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');

        $result = ReturnJualHeadModel::whereYear('tgl_return', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_return)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut);
        } else {
            $no_trans_baru = (int)substr($result->no_return, 10, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

    //return pemberian sample
    public function return_pemberian_sample()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('return.pemberianSample.index', $data);
    }
    public function search_invoice_pemberian_sample(Request $request)
    {
        $keyword = $request->search;
        $result = JualHeadModel::where('no_invoice', $keyword)->where('jenis_jual', 1)->first();
        if(empty($result->id))
        {
            $response = [
                'success' => 'false',
                'message' => 'Nomor Invoice Tidak Ditemukan',
                'data' => ''
            ];
        } else {
            $response = [
                'success' => 'true',
                'message' => 'Nomor Invoice Ditemukan. Melanjutkan ke Form Return ?',
                'data' => $result
            ];
        }
        return response()
            ->json($response)
            ->withCallback($request->input('callback'));
    }

    public function filter_invoice_pemberian_sample_detail($id_invoice)
    {
        $data = [
            'dtHead' => JualHeadModel::with('get_detail', 'get_detail.get_produk')->find($id_invoice)
        ];
        return view('return.pemberianSample.detail_invoice', $data);
    }
    public function filter_invoice_pemberian_sample($id_customer)
    {
        $result = JualHeadModel::with('get_detail')->where('customer_id', $id_customer)->where('jenis_jual', 1)->orderby('tgl_invoice', 'desc')->get();

        $data = [
            'list_invoice' => $result
        ];
        return view('return.pemberianSample.daftar_invoice', $data);
    }

    public function return_pemberian_sample_store(Request $request)
    {
        try {

            $save_head = new ReturnPemberianSampleHeadModel();
            //store header
            $save_head->no_return = $this->create_no_return_pemberian_sample();
            $save_head->jual_id = $request->inpInvoiceId;
            $save_head->tgl_return = ($request->inpTglReturn=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglReturn)));
            $save_head->total_qty = str_replace(",","", $request->inputTotal);
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
                        $newdetail = new ReturnPemberianSampleDetailModel();
                        $newdetail->head_id = $id_head;
                        $newdetail->produk_id = $value['item_id'][$i];
                        $newdetail->qty = str_replace(",","", $value['qty_return'][$i]);
                        $newdetail->save();
                        //update invoice
                        $update_invoice = JualDetailModel::find($value['id_detail'][$i]);
                        $update_invoice->qty_return = ((int)$update_invoice->qty_return +  (int)str_replace(",","", $value['qty_return'][$i]));
                        $update_invoice->save();
                        //Update Stok
                        $update = ProductModel::find($value['item_id'][$i]);
                        $update->stok_akhir = ((int)$update->stok_akhir +  (int)str_replace(",","", $value['qty_return'][$i]));
                        $update->save();
                    }
                }
            }
            if($id_head)
            {
                return redirect('returnPemberianSample')->with('message', 'Return Pemberian Sample Berhasil Disimpan');
            } else {
                return redirect('returnPemberianSample')->with('message', 'Return Pemberian Sample Gagal Disimpan');
            }

        } catch (QueryException $e)
        {
            return redirect('returnPemberianSample')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_return_pemberian_sample()
    {
        $no_urut = 1;
        $kd="RTPS"; //Return Jual
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');

        $result = ReturnPemberianSampleHeadModel::whereYear('created_at', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_return)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut);
        } else {
            $no_trans_baru = (int)substr($result->no_return, 11, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }
}
