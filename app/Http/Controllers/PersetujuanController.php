<?php

namespace App\Http\Controllers;

use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\ProductModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function persetujuan_penjualan()
    {
        return view('persetujuan.penjualan.index');
    }

    public function persetujuan_penjualan_filter($tgl_awal=null, $tgl_akhir=null)
    {
        $result = JualHeadModel::whereDate('tgl_invoice', '>=', $tgl_awal)
                            ->whereDate('tgl_invoice', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->whereNull('approved')
                            ->orderby('tgl_invoice', 'asc')->get();
        $data = [
            'list_data' => $result
        ];
        return view('persetujuan.penjualan.list', $data);
    }

    public function persetujuan_penjualan_approve($id)
    {
        $head_trans = JualHeadModel::find($id);
        $data = [
            'head' => $head_trans
        ];

        return view('persetujuan.penjualan.approve', $data);
    }

    public function persetujuan_penjualan_store(Request $request)
    {
        try {
            $detail_trans = JualDetailModel::where('head_id', $request->id_trans);
            foreach($detail_trans as $list)
            {
                //Update Stok
                $update = ProductModel::find($list->produk_id);
                $update->stok_akhir = ((int)$update->stok_akhir -  (int)$list->qty);
                $update->save();
            }
            return redirect('persetujuanPenjualan')->with('message', 'Transaksi berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('persetujuanPenjualan')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }
}
