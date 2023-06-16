<?php

namespace App\Http\Controllers;

use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\POHeadModel;
use App\Models\ProductModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    protected $datetimeStore;

    public function __construct()
    {
        $this->middleware('auth');
        $this->datetimeStore = date("Y-m-d h:i:s");
    }

    public function persetujuan_penjualan()
    {
        return view('persetujuan.penjualan.index');
    }

    public function persetujuan_penjualan_data()
    {
        $result = JualHeadModel::whereNull('jenis_jual')
                            ->whereNull('status_approval')
                            ->orwhereNull('jenis_jual')
                            ->where('status_approval', 2)
                            ->orderby('tgl_transaksi', 'desc')
                            ->orderby('status_approval', 'desc')->get();
        $data = [
            'list_data' => $result
        ];
        return view('persetujuan.penjualan.list', $data);
    }

    public function persetujuan_penjualan_filter($tgl_awal=null, $tgl_akhir=null)
    {
        $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->whereNull('status_approval')
                            ->orwhereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->where('status_approval', 2)
                            ->orderby('tgl_transaksi', 'desc')
                            ->orderby('status_approval', 'desc')->get();
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
            $update_head = JualHeadModel::find($request->id_trans);
            $update_head->tgl_transaksi = date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_trans)));
            $update_head->approved = $request->selApproval;
            $update_head->approved_date = $this->datetimeStore;
            $update_head->approved_note = $request->inp_catatan_persetujuan;
            $update_head->approved_by = auth()->user()->id;
            if($request->selApproval==2)
            {
                $update_head->status_approval = $request->selApproval;
            }
            $update_head->save();
            return redirect('persetujuanPenjualan')->with('message', 'Transaksi berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('persetujuanPenjualan')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }
    //level 2
    public function persetujuan_penjualan_approve_2($id)
    {
        $head_trans = JualHeadModel::find($id);
        $data = [
            'head' => $head_trans
        ];

        return view('persetujuan.penjualan.approve_2', $data);
    }

    public function persetujuan_penjualan_store_2(Request $request)
    {
        try {
            $update_head = JualHeadModel::find($request->id_trans);
            $update_head->tgl_transaksi = date("Y-m-d", strtotime(str_replace("/", "-", $request->inp_tgl_trans)));
            $update_head->approved_2 = $request->selApproval;
            $update_head->approved_date_2 = $this->datetimeStore;
            $update_head->approved_note_2 = $request->inp_catatan_persetujuan;
            $update_head->approved_by_2 = auth()->user()->id;
            $update_head->status_approval = $request->selApproval;
            $update_head->save();
            if($request->selApproval==1)
            {
                $detail_trans = JualDetailModel::where('head_id', $request->id_trans)->get();
                foreach($detail_trans as $list)
                {
                    //Update Stok
                    $update = ProductModel::find($list->produk_id);
                    $update->stok_akhir = ((int)$update->stok_akhir -  (int)$list->qty);
                    $update->save();
                }
            }
            return redirect('persetujuanPenjualan')->with('message', 'Transaksi berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('persetujuanPenjualan')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    //persetujuan po
    public function persetujuan_po()
    {
        return view('persetujuan.po.index');
    }
    public function persetujuan_po_data()
    {
        $result = POHeadModel::whereNull('status_approval')
                            ->orwhere('status_approval', 2)
                            ->orderby('tanggal_po', 'desc')
                            ->orderby('status_approval', 'desc')->get();
        $data = [
            'list_data' => $result
        ];
        return view('persetujuan.po.list', $data);
    }
    public function persetujuan_po_filter($tgl_awal=null, $tgl_akhir=null)
    {
        $result = POHeadModel::whereDate('tanggal_po', '>=', $tgl_awal)
                            ->whereDate('tanggal_po', '<=', $tgl_akhir)
                            ->whereNull('status_approval')
                            ->orwhereDate('tanggal_po', '>=', $tgl_awal)
                            ->whereDate('tanggal_po', '<=', $tgl_akhir)
                            ->where('status_approval', 2)
                            ->orderby('tanggal_po', 'desc')
                            ->orderby('status_approval', 'desc')->get();
        $data = [
            'list_data' => $result
        ];
        return view('persetujuan.po.list', $data);
    }

    public function persetujuan_po_approve($id)
    {
        $head_trans = POHeadModel::find($id);
        $data = [
            'resHead' => $head_trans
        ];

        return view('persetujuan.po.approve', $data);
    }

    public function persetujuan_po_store(Request $request)
    {
        try {
            $update_head = POHeadModel::find($request->id_po);
            $update_head->approved = $request->selApproval;
            $update_head->approved_date = $this->datetimeStore;
            $update_head->approved_note = $request->inp_catatan_persetujuan;
            $update_head->approved_by = auth()->user()->id;
            if($request->selApproval==2)
            {
                $update_head->status_approval = $request->selApproval;
            }
            $update_head->save();
            return redirect('persetujuanPO')->with('message', 'Persetujuan PO berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('persetujuanPO')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    //level 2
    public function persetujuan_po_approve_2($id)
    {
        $head_trans = POHeadModel::find($id);
        $data = [
            'resHead' => $head_trans
        ];

        return view('persetujuan.po.approve_2', $data);
    }

    public function persetujuan_po_store_2(Request $request)
    {
        try {
            $update_head = POHeadModel::find($request->id_po);
            $update_head->approved_2 = $request->selApproval;
            $update_head->approved_date_2 = $this->datetimeStore;
            $update_head->approved_note_2 = $request->inp_catatan_persetujuan;
            $update_head->approved_by_2 = auth()->user()->id;
            $update_head->status_approval = $request->selApproval;
            if($request->selApproval==1)
            {
                $update_head->status_po = 1;
            }
            $update_head->save();
            return redirect('persetujuanPO')->with('message', 'Persetujuan PO berhasil disimpan');
        } catch (QueryException $e)
        {
            return redirect('persetujuanPO')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

}
