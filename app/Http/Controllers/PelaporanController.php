<?php

namespace App\Http\Controllers;

use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use Illuminate\Http\Request;

class PelaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function laporan_pembelian()
    {
        return view('pelaporan.pembelian.index');
    }

    //laporan penjualan
    public function laporan_penjualam()
    {
        return view('pelaporan.penjualan.index');
    }
    public function laporan_penjualan_filter(Request $request)
    {
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $result = JualHeadModel::whereDate('tgl_invoice', '>=', $tgl_awal)
                            ->whereDate('tgl_invoice', '<=', $tgl_akhir)->get();
        $nom=1;
        $total_net = 0;
        $html="";
        $html_summary="";
        foreach($result as $list)
        {
            // $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail" id="tbl" title="Klik untuk melihat detail" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"</button>';
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"</button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_invoice), 'd-m-Y')."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td>".$list->get_customer->nama_customer."</td>
            <td style='text-align: right;'>".number_format($list->total_invoice, 0)."</td>
            <td style='text-align: right;'>".$list->diskon_persen."</td>
            <td style='text-align: right;'>".$list->ppn_persen."</td>
            <td style='text-align: right;'>".number_format($list->ongkir, 0)."</td>
            <td style='text-align: right;'>".number_format($list->total_invoice_net, 0)."</td>
            </tr>";
            $nom++;
            $total_net+=$list->total_invoice_net;
        }
        $html .= "<tr>
            <td colspan='9' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'>".number_format($total_net, 0)."</td>
        ";
        return response()
            ->json([
                'all_result' => $html,
                // 'result_summary' => $html_summary,
                'periode' => "Periode : ".$request->ket_periode
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_penjualan_detail($id)
    {
        $data['head'] = JualHeadModel::find($id);
        $data['all_detail'] = JualDetailModel::where('head_id', $id)->get();
        return view('pelaporan.penjualan.detail', $data);
    }
}
