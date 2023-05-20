<?php

namespace App\Http\Controllers;

use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\ProductModel;
use App\Models\ReceiveDetailModel;
use App\Models\ReceiveHeadModel;
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

    public function laporan_pembelian_filter(Request $request)
    {
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $result_receive = ReceiveHeadModel::whereDate('tanggal_receive', '>=', $tgl_awal)
        ->whereDate('tanggal_receive', '<=', $tgl_akhir)->get();

        $nom=1;
        $total_net = 0;
        $html="";
        $html_summary="";
        foreach($result_receive as $list)
        {
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_invoice), 'd-m-Y')."</td>
            <td>".$list->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'>".number_format($list->total_receice, 0)."</td>
            <td style='text-align: right;'>".$list->diskon_persen."</td>
            <td style='text-align: right;'>".$list->ppn_persen."</td>
            <td style='text-align: right;'>".number_format($list->total_receive_net, 0)."</td>
            </tr>";
            $nom++;
            $total_net+=$list->total_receive_net;
        }
        $html .= "<tr>
            <td colspan='8' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'>".number_format($total_net, 0)."</td>
        ";

        $nom_summary=1;
        $total_qty_summary=0;
        $total_harga_summary=0;
        $query_summary = \DB::table('receive_head')
                        ->selectRaw('common_product.kode, common_product.nama_produk, SUM(receive_detail.qty) as total, SUM(receive_detail.sub_total_net) as harga')
                        ->join('receive_detail', 'receive_detail.head_id', '=', 'receive_head.id')
                        ->join('common_product', 'common_product.id', '=', 'receive_detail.produk_id')
                        ->whereNull('receive_head.deleted_at')
                        // ->whereBetween('penjualan_head.tgl_trans', [$tgl_awal, $tgl_akhir])
                         ->whereDate('receive_head.tanggal_receive', '>=', $tgl_awal)
                        ->whereDate('receive_head.tanggal_receive', '<=', $tgl_akhir)
                        ->groupBy('receive_detail.produk_id')
                        ->orderByDesc('total')
                        ->get();
        foreach($query_summary as $summary)
        {
            $html_summary .="<tr>
            <td style='text-align: center;'>".$nom_summary."</td>
            <td>".$summary->nama_produk."</td>
            <td style='text-align: center;'>".$summary->total."</td>
            <td style='text-align: right;'>".number_format($summary->harga, 0)."</td>
            </tr>";
            $nom_summary++;
            $total_qty_summary+=$summary->total;
            $total_harga_summary+=$summary->harga;
        }
        $html_summary .= "<tr>
            <td colspan='2' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: center;'><b>".$total_qty_summary."</b></td>
            <td style='text-align: right;'><b>".number_format($total_harga_summary, 0)."</b></td>
        ";

        return response()
            ->json([
                'all_result' => $html,
                'result_summary' => $html_summary,
                'periode' => "Periode : ".$request->ket_periode
            ])
            ->withCallback($request->input('callback'));
        
    }

    public function laporan_pembelian_detail($id)
    {
        $data['head'] = ReceiveHeadModel::find($id);
        $data['all_detail'] = ReceiveDetailModel::where('head_id', $id)->get();
        return view('pelaporan.pembelian.detail', $data);
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
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

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
        $nom_summary=1;
        $total_qty_summary=0;
        $total_harga_summary=0;
        $query_summary = \DB::table('jual_head')
                        ->selectRaw('common_product.kode, common_product.nama_produk, SUM(jual_detail.qty) as total, SUM(jual_detail.sub_total_net) as harga')
                        ->join('jual_detail', 'jual_detail.head_id', '=', 'jual_head.id')
                        ->join('common_product', 'common_product.id', '=', 'jual_detail.produk_id')
                        ->whereNull('jual_head.deleted_at')
                        // ->whereBetween('penjualan_head.tgl_trans', [$tgl_awal, $tgl_akhir])
                         ->whereDate('jual_head.tgl_invoice', '>=', $tgl_awal)
                        ->whereDate('jual_head.tgl_invoice', '<=', $tgl_akhir)
                        ->groupBy('jual_detail.produk_id')
                        ->orderByDesc('total')
                        ->get();
        foreach($query_summary as $summary)
        {
            $html_summary .="<tr>
            <td style='text-align: center;'>".$nom_summary."</td>
            <td>".$summary->nama_produk."</td>
            <td style='text-align: center;'>".$summary->total."</td>
            <td style='text-align: right;'>".number_format($summary->harga, 0)."</td>
            </tr>";
            $nom_summary++;
            $total_qty_summary+=$summary->total;
            $total_harga_summary+=$summary->harga;
        }
        $html_summary .= "<tr>
            <td colspan='2' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: center;'><b>".$total_qty_summary."</b></td>
            <td style='text-align: right;'><b>".number_format($total_harga_summary, 0)."</b></td>
        ";
        return response()
            ->json([
                'all_result' => $html,
                'result_summary' => $html_summary,
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

    public function laporan_stok()
    {
        return view('pelaporan.stok.index');
    }

    public function laporan_stok_filter(Request $request)
    {
        $tgl_1 = $request->tgl_1;
        $tgl_2 = $request->tgl_2;
        $result = ProductModel::orderBy('id')->get();
        // dd($result);
        $nom=1;
        $html="";
        $qty_penjualan_cancel=0;
        $qty_pembelian_cancel=0;
        foreach($result as $list)
        {
            //stok awal
            $qty_awal = ProductModel::find($list->id)->stok_awal;
            $qty_pembelian_awal = \DB::table('receive_head')
                                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                                ->whereDate('receive_head.tanggal_receive', '<', $tgl_1)
                                ->where('receive_detail.produk_id', $list->id)
                                ->whereNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_detail.qty) as t_pembelian_awal')
                                ->pluck('t_pembelian_awal')->first();
            $qty_penjualan_awal = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_invoice', '<', $tgl_1)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                                ->pluck('t_penjualan_awal')->first();
            $stok_awal = ($qty_awal + $qty_pembelian_awal) - $qty_penjualan_awal;
            //range date selected
            $qty_pembelian = \DB::table('receive_head')
                                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                                ->whereDate('receive_head.tanggal_receive', '>=', $tgl_1)
                                ->whereDate('receive_head.tanggal_receive', '<=', $tgl_2)
                                ->where('receive_detail.produk_id', $list->id)
                                ->whereNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_detail.qty) as t_pembelian')
                                ->pluck('t_pembelian')->first();

            $qty_pembelian_cancel = \DB::table('receive_head')
                                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                                ->whereDate('receive_head.tanggal_receive', '>=', $tgl_1)
                                ->whereDate('receive_head.tanggal_receive', '<=', $tgl_2)
                                ->where('receive_detail.produk_id', $list->id)
                                ->whereNotNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_detail.qty) as t_pembelian')
                                ->pluck('t_pembelian')->first();

            $qty_penjualan = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_invoice', '>=', $tgl_1)
                                ->whereDate('jual_head.tgl_invoice', '<=', $tgl_2)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                                ->pluck('t_penjualan')->first();

            $qty_penjualan_cancel = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_invoice', '>=', $tgl_1)
                                ->whereDate('jual_head.tgl_invoice', '<=', $tgl_2)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNotNull('jual_head.deleted_at')
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                                ->pluck('t_penjualan')->first();

            //stok akhir
            $current_qty = ($stok_awal + $qty_pembelian + $qty_pembelian_cancel) - ($qty_penjualan + $qty_penjualan_cancel);
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->kode."</td>
            <td>".$list->nama_produk."</td>
            <td style='text-align: center;'><span class='badge bg-info' style='font-size: 12pt;'>".$stok_awal."</span></td>
            <td style='text-align: right;'>".number_format($list->harga_eceran, 0)."</td>
            <td style='text-align: center;'><span class='badge bg-warning' style='font-size: 12pt;'>".((!empty($qty_pembelian)) ? $qty_pembelian : 0)."</span></td>
            <td style='text-align: center;'><span class='badge bg-success' style='font-size: 12pt;'>".((!empty($qty_penjualan)) ? $qty_penjualan : 0)."</span></td>
            <td style='text-align: center;'><span class='badge bg-danger' style='font-size: 12pt;'>".((!empty($qty_pembelian_cancel)) ? $qty_pembelian_cancel : 0)."</span></td>
            <td style='text-align: center;'><span class='badge bg-danger' style='font-size: 12pt;'>".((!empty($qty_penjualan_cancel)) ? $qty_penjualan_cancel : 0)."</span></td>
            <td style='text-align: center;'><span class='badge bg-primary' style='font-size: 12pt;'>".$current_qty."</span></td>
            </tr>";
            $nom++;
        }
        return response()->json([
            'all_result' => $html,
            'periode' => "Periode : ".$request->ket_periode
        ]);
        // echo $html;
    }

}
