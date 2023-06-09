<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\HutangKontainerModel;
use App\Models\HutangModel;
use App\Models\JualDetailModel;
use App\Models\JualHeadModel;
use App\Models\KontainerModel;
use App\Models\PiutangModel;
use App\Models\ProductModel;
use App\Models\ReceiveDetailModel;
use App\Models\ReceiveHeadModel;
use App\Models\ReturnBeliHeadModel;
use App\Models\ReturnJualHeadModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use PDF;

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
        $result_receive = ReceiveHeadModel::whereDate('tgl_tiba', '>=', $tgl_awal)
        ->whereDate('tgl_tiba', '<=', $tgl_akhir)->get();

        $nom=1;
        $total_net = 0;
        $total_bayar = 0;
        $total_outs = 0;
        $html="";
        // $html_summary="";
        foreach($result_receive as $list)
        {
            $ket_bayar = ($list->cara_bayar==1) ? 'Tunai' : 'Kredit';
            if($list->cara_bayar==2)
            {
                $total_terbayar_invoice = \DB::table('hutang_kontainer')
                                ->where('hutang_kontainer.receive_id', $list->id)
                                ->whereNull('hutang_kontainer.deleted_at')
                                ->selectRaw('sum(hutang_kontainer.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();
                $outs_invoice = $list->total_receive_net - $total_terbayar_invoice;
            } else {
                $total_terbayar_invoice = $list->total_receive_net;
                $outs_invoice = 0;
            }
            
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_invoice), 'd-m-Y')."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_tiba), 'd-m-Y')."</td>
            <td>".$list->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'><b>".number_format($list->total_receive_net, 0)."</b></td>
            <td style='text-align: right;'><b>".number_format($total_terbayar_invoice, 0)."</b></td>
            <td style='text-align: right;'><b>".number_format($outs_invoice, 0)."</b></td>
            <td style='text-align: center;'>".$ket_bayar."</td>
            </tr>";
            $nom++;
            $total_net+=$list->total_receive_net;
            $total_bayar+=$total_terbayar_invoice;
            $total_outs+=$list->outs_invoice;
        }
        $html .= "<tr>
            <td colspan='6' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total_net, 0)."</b></td>
            <td style='text-align: right;'><b>".number_format($total_bayar, 0)."</b></td>
            <td style='text-align: right;'><b>".number_format($total_outs, 0)."</b></td>
            <td></td>
        ";
        return response()
            ->json([
                'all_result' => $html,
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

    public function laporan_pembelian_print($tgl_1=null, $tgl_2=null, $view_detail=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        $result = ReceiveHeadModel::whereDate('tgl_tiba', '>=', $tgl_1)
                        ->whereDate('tgl_tiba', '<=', $tgl_2)->get();

        $pdf = PDF::loadview('pelaporan.pembelian.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'check_view_detail' => $view_detail
        ])->setPaper('A4', "landscape",);
        return $pdf->stream();

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
        $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->whereNULL('jenis_jual')->get();
        $nom=1;
        $total_net = 0;
        $ket_via = "";
        $html="";
        foreach($result as $list)
        {
            $cara_bayar = ($list->bayar_via==1) ? "Tunai/" : "Kredit";
            if($list->bayar_via==1)
            {
                $ket_via = (empty($list->get_via->penerimaan)) ? "" : $list->get_via->penerimaan;
            } 
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_transaksi), 'd-m-Y')."</td>
            <td>".$list->get_customer->nama_customer."</td>
            <td style='text-align: right;'>".number_format($list->total_invoice, 0)."</td>
            <td style='text-align: right;'>".$list->diskon_persen."</td>
            <td style='text-align: right;'>".$list->ppn_persen."</td>
            <td style='text-align: right;'>".number_format($list->ongkir, 0)."</td>
            <td style='text-align: right;'><b>".number_format($list->total_invoice_net, 0)."</b></td>
            <td>".$cara_bayar.$ket_via."</td>
            </tr>";
            $nom++;
            $total_net+=$list->total_invoice_net;
        }
        $html .= "<tr>
            <td colspan='9' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total_net, 0)."</b></td>
            <td></td>
        ";
        return response()
            ->json([
                'all_result' => $html,
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

    
    public function laporan_penjualan_print($tgl_1=null, $tgl_2=null, $view_detail=null)
    {
        $tgl_awal = $tgl_1;
        $tgl_akhir = $tgl_2;
        $ket_periode = $tgl_1." s/d ".$tgl_2;

        $result = JualHeadModel::whereDate('tgl_invoice', '>=', $tgl_awal)
                            ->whereDate('tgl_invoice', '<=', $tgl_akhir)->whereNULL('jenis_jual')->get();
        
        $pdf = PDF::loadview('pelaporan.penjualan.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'check_view_detail' => $view_detail
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
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
            //+
            $qty_pembelian_awal = \DB::table('receive_head')
                                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                                ->whereDate('receive_head.tgl_tiba', '<', $tgl_1)
                                ->where('receive_detail.produk_id', $list->id)
                                ->whereNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_detail.qty) as t_pembelian_awal')
                                ->pluck('t_pembelian_awal')->first();

            $qty_return_jual_awal = \DB::table('return_jual_head')
                                ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                                ->whereDate('return_jual_head.tgl_return', '<', $tgl_1)
                                ->where('return_jual_detail.produk_id', $list->id)
                                ->whereNull('return_jual_head.deleted_at')
                                ->selectRaw('sum(return_jual_detail.qty) as t_return_jual_awal')
                                ->pluck('t_return_jual_awal')->first();
            //-
            $qty_penjualan_awal = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->whereNULL('jual_head.jenis_jual')
                                ->where('jual_head.approved', 1)
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                                ->pluck('t_penjualan_awal')->first();

            $qty_return_beli_awal = \DB::table('return_beli_head')
                                ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                                ->whereDate('return_beli_head.tgl_return', '<', $tgl_1)
                                ->where('return_beli_detail.produk_id', $list->id)
                                ->whereNull('return_beli_head.deleted_at')
                                ->selectRaw('sum(return_beli_detail.qty) as t_return_beli_awal')
                                ->pluck('t_return_beli_awal')->first();

            $qty_pemberian_sampel = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->where('jual_head.jenis_jual', 1)
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                                ->pluck('t_penjualan_awal')->first();
            
            $stok_awal = ($qty_awal + $qty_pembelian_awal + $qty_return_jual_awal) - ($qty_penjualan_awal + $qty_return_beli_awal + $qty_pemberian_sampel);

            //range date selected
            //stok masuk
            $qty_pembelian = \DB::table('receive_head')
                    ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                    ->whereDate('receive_head.tgl_tiba', '>=', $tgl_1)
                    ->whereDate('receive_head.tgl_tiba', '<=', $tgl_2)
                    ->where('receive_detail.produk_id', $list->id)
                    ->whereNull('receive_head.deleted_at')
                    ->selectRaw('sum(receive_detail.qty) as t_pembelian')
                    ->pluck('t_pembelian')->first();
            $qty_return_jual = \DB::table('return_jual_head')
                    ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                    ->whereDate('return_jual_head.tgl_return', '>=', $tgl_1)
                    ->whereDate('return_jual_head.tgl_return', '<=', $tgl_2)
                    ->where('return_jual_detail.produk_id', $list->id)
                    ->whereNull('return_jual_head.deleted_at')
                    ->selectRaw('sum(return_jual_detail.qty) as t_return_jual')
                    ->pluck('t_return_jual')->first();
            //stok keluar
            $qty_penjualan = \DB::table('jual_head')
                    ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                    ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                    ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                    ->where('jual_detail.produk_id', $list->id)
                    ->whereNull('jual_head.deleted_at')
                    ->whereNull('jual_head.jenis_jual')
                    ->where('jual_head.approved', 1)
                    ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                    ->pluck('t_penjualan')->first();
            $qty_pemberian_sampel = \DB::table('jual_head')
                    ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                    ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                    ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                    ->where('jual_detail.produk_id', $list->id)
                    ->whereNull('jual_head.deleted_at')
                    ->where('jual_head.jenis_jual', 1)
                    ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                    ->pluck('t_penjualan')->first();
            $qty_return_beli = \DB::table('return_beli_head')
                    ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                    ->whereDate('return_beli_head.tgl_return', '>=', $tgl_1)
                    ->whereDate('return_beli_head.tgl_return', '<=', $tgl_2)
                    ->where('return_beli_detail.produk_id', $list->id)
                    ->whereNull('return_beli_head.deleted_at')
                    ->selectRaw('sum(return_beli_detail.qty) as t_return_beli')
                    ->pluck('t_return_beli')->first();

            //stok akhir
            $stok_masuk = $qty_pembelian + $qty_return_jual;
            $stok_keluar = $qty_penjualan + $qty_return_beli + $qty_pemberian_sampel;
            //stok akhir
            $current_qty = ($stok_awal + $stok_masuk) - $stok_keluar;
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->kode."</td>
            <td>".$list->nama_produk."</td>
            <td style='text-align: center;'>".$list->get_merk->merk."</td>
            <td style='text-align: center;'>".$list->kemasan." ".$list->get_unit->unit."</td>
            <td style='text-align: center;'><span class='badge bg-info' style='font-size: 12pt;'>".$stok_awal."</span></td>
            <td style='text-align: right;'>".number_format($list->harga_eceran, 0)."</td>
            <td style='text-align: center;'><span class='badge bg-warning' style='font-size: 12pt;'>".((!empty($stok_masuk)) ? $stok_masuk : 0)."</span></td>
            <td style='text-align: center;'><span class='badge bg-success' style='font-size: 12pt;'>".((!empty($stok_keluar)) ? $stok_keluar : 0)."</span></td>
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

    public function laporan_stok_print($tgl_1=null, $tgl_2=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        $result = ProductModel::orderBy('id')->get();
        $nom=1;
        $html="";
        $qty_penjualan_cancel=0;
        $qty_pembelian_cancel=0;
        foreach($result as $list)
        {
            //stok awal
            $qty_awal = ProductModel::find($list->id)->stok_awal;
            //+
            $qty_pembelian_awal = \DB::table('receive_head')
                                ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                                ->whereDate('receive_head.tgl_invoice', '<', $tgl_1)
                                ->where('receive_detail.produk_id', $list->id)
                                ->whereNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_detail.qty) as t_pembelian_awal')
                                ->pluck('t_pembelian_awal')->first();

            $qty_return_jual_awal = \DB::table('return_jual_head')
                                ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                                ->whereDate('return_jual_head.tgl_return', '<', $tgl_1)
                                ->where('return_jual_detail.produk_id', $list->id)
                                ->whereNull('return_jual_head.deleted_at')
                                ->selectRaw('sum(return_jual_detail.qty) as t_return_jual_awal')
                                ->pluck('t_return_jual_awal')->first();
            //-
            $qty_penjualan_awal = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->whereNULL('jual_head.jenis_jual')
                                ->where('jual_head.approved', 1)
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                                ->pluck('t_penjualan_awal')->first();

            $qty_return_beli_awal = \DB::table('return_beli_head')
                                ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                                ->whereDate('return_beli_head.tgl_return', '<', $tgl_1)
                                ->where('return_beli_detail.produk_id', $list->id)
                                ->whereNull('return_beli_head.deleted_at')
                                ->selectRaw('sum(return_beli_detail.qty) as t_return_beli_awal')
                                ->pluck('t_return_beli_awal')->first();

            $qty_pemberian_sampel = \DB::table('jual_head')
                                ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                                ->whereDate('jual_head.tgl_transaksi', '<', $tgl_1)
                                ->where('jual_detail.produk_id', $list->id)
                                ->whereNull('jual_head.deleted_at')
                                ->where('jual_head.jenis_jual', 1)
                                ->selectRaw('sum(jual_detail.qty) as t_penjualan_awal')
                                ->pluck('t_penjualan_awal')->first();
            
            $stok_awal = ($qty_awal + $qty_pembelian_awal + $qty_return_jual_awal) - ($qty_penjualan_awal + $qty_return_beli_awal + $qty_pemberian_sampel);

            //range date selected
            //stok masuk
            $qty_pembelian = \DB::table('receive_head')
                    ->join('receive_detail', 'receive_head.id', '=', 'receive_detail.head_id')
                    ->whereDate('receive_head.tgl_invoice', '>=', $tgl_1)
                    ->whereDate('receive_head.tgl_invoice', '<=', $tgl_2)
                    ->where('receive_detail.produk_id', $list->id)
                    ->whereNull('receive_head.deleted_at')
                    ->selectRaw('sum(receive_detail.qty) as t_pembelian')
                    ->pluck('t_pembelian')->first();
            $qty_return_jual = \DB::table('return_jual_head')
                    ->join('return_jual_detail', 'return_jual_head.id', '=', 'return_jual_detail.head_id')
                    ->whereDate('return_jual_head.tgl_return', '>=', $tgl_1)
                    ->whereDate('return_jual_head.tgl_return', '<=', $tgl_2)
                    ->where('return_jual_detail.produk_id', $list->id)
                    ->whereNull('return_jual_head.deleted_at')
                    ->selectRaw('sum(return_jual_detail.qty) as t_return_jual')
                    ->pluck('t_return_jual')->first();
            //stok keluar
            $qty_penjualan = \DB::table('jual_head')
                    ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                    ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                    ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                    ->where('jual_detail.produk_id', $list->id)
                    ->whereNull('jual_head.deleted_at')
                    ->whereNull('jual_head.jenis_jual')
                    ->where('jual_head.approved', 1)
                    ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                    ->pluck('t_penjualan')->first();
            $qty_pemberian_sampel = \DB::table('jual_head')
                    ->join('jual_detail', 'jual_head.id', '=', 'jual_detail.head_id')
                    ->whereDate('jual_head.tgl_transaksi', '>=', $tgl_1)
                    ->whereDate('jual_head.tgl_transaksi', '<=', $tgl_2)
                    ->where('jual_detail.produk_id', $list->id)
                    ->whereNull('jual_head.deleted_at')
                    ->where('jual_head.jenis_jual', 1)
                    ->selectRaw('sum(jual_detail.qty) as t_penjualan')
                    ->pluck('t_penjualan')->first();
            $qty_return_beli = \DB::table('return_beli_head')
                    ->join('return_beli_detail', 'return_beli_head.id', '=', 'return_beli_detail.head_id')
                    ->whereDate('return_beli_head.tgl_return', '>=', $tgl_1)
                    ->whereDate('return_beli_head.tgl_return', '<=', $tgl_2)
                    ->where('return_beli_detail.produk_id', $list->id)
                    ->whereNull('return_beli_head.deleted_at')
                    ->selectRaw('sum(return_beli_detail.qty) as t_return_beli')
                    ->pluck('t_return_beli')->first();

            //stok akhir
            $stok_masuk = $qty_pembelian + $qty_return_jual;
            $stok_keluar = $qty_penjualan + $qty_return_beli + $qty_pemberian_sampel;
            //stok akhir
            $current_qty = ($stok_awal + $stok_masuk) - $stok_keluar;
            $data[] = [
                'no_urut' => $nom,
                'kode' => $list->kode,
                'nama_produk' => $list->nama_produk,
                'merk' => $list->get_merk->merk,
                'satuan' => $list->get_unit->unit,
                'kemasan' => $list->kemasan,
                'stok_awal' => $stok_awal,
                'harga_jual' => $list->harga_eceran,
                'stok_masuk' => ((!empty($stok_masuk)) ? $stok_masuk : 0),
                'stok_keluar' => ((!empty($stok_keluar)) ? $stok_keluar : 0),
                'stok_akhir' => $current_qty,
            ];
            $nom++;
        }
        $newData = json_encode($data, TRUE);

        $pdf = PDF::loadview('pelaporan.stok.print', [
            'list_data' => json_decode($newData, true),
            'periode' => $ket_periode
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    //laporan pemberian sampel
    public function laporan_pemberian_sampel()
    {
        return view('pelaporan.pemberian_sampel.index');
    }

    public function laporan_pemberian_sampel_filter(Request $request)
    {
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->where('jenis_jual', 1)->get();
        $nom=1;
        $total = 0;
        $html="";
        $html_summary="";
        foreach($result as $list)
        {
            $tot_qty = $list->get_detail->sum('qty');
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_transaksi), 'd-m-Y')."</td>
            <td>".$list->get_customer->nama_customer."</td>
            <td style='text-align: center;'>".$tot_qty."</td>
            <td style='text-align: center;'>".$list->keterangan."</td>
            </tr>";
            $nom++;
            $total+=$tot_qty;
        }
        $html .= "<tr>
            <td colspan='4' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: center;'>".$total."</td>
            <td></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_pemberian_sampel_detail($id)
    {
        $data['head'] = JualHeadModel::find($id);
        $data['all_detail'] = JualDetailModel::where('head_id', $id)->get();
        return view('pelaporan.pemberian_sampel.detail', $data);
    }

    public function laporan_pemberian_sampel_print($tgl_1=null, $tgl_2=null, $view_detail=null)
    {
        $tgl_awal = $tgl_1;
        $tgl_akhir = $tgl_2;
        $ket_periode = $tgl_1." s/d ".$tgl_2;

        $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)->where('jenis_jual', 1)->get();
        
        $pdf = PDF::loadview('pelaporan.pemberian_sampel.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'check_view_detail' => $view_detail
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }
    //laporan return pembelian
    public function laporan_return_pembelian()
    {
        return view('pelaporan.return_beli.index');
    }

    public function laporan_return_pembelian_filter(Request $request)
    {
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $result = ReturnBeliHeadModel::whereDate('tgl_return', '>=', $tgl_awal)
                            ->whereDate('tgl_return', '<=', $tgl_akhir)
                            ->orderby('tgl_return', 'asc')->get();
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            $tot_qty = $list->get_detail->sum('qty');
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_return."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_return), 'd-m-Y')."</td>
            <td>".$list->get_receive->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'><b>".number_format($list->total_return, 0)."</b></td>
            </tr>";
            $nom++;
            $total+=$list->total_return;
        }
        $html .= "<tr>
            <td colspan='5' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total, )."</b></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_return_pembelian_detail($id)
    {
        $data['head'] = ReturnBeliHeadModel::find($id);
        return view('pelaporan.return_beli.detail', $data);
    }

    public function laporan_return_pembelian_print($tgl_1=null, $tgl_2=null, $view_detail=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        $result = ReturnBeliHeadModel::whereDate('tgl_return', '>=', $tgl_1)
                        ->whereDate('tgl_return', '<=', $tgl_2)->get();

        $pdf = PDF::loadview('pelaporan.return_beli.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'check_view_detail' => $view_detail
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();

    }
    //laporan return penjualan
    public function laporan_return_penjualan()
    {
        return view('pelaporan.return_jual.index');
    }

    public function laporan_return_penjualan_filter(Request $request)
    {
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;
        $result = ReturnJualHeadModel::whereDate('tgl_return', '>=', $tgl_awal)
                            ->whereDate('tgl_return', '<=', $tgl_akhir)
                            ->orderby('tgl_return', 'asc')->get();
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            $tot_qty = $list->get_detail->sum('qty');
            $tbl_aksi = '<button type="button" class="btn btn-block btn-outline-danger btn-sm" name="tbl-detail[]" id="tbl" title="Klik untuk melihat detail" data-toggle="modal" data-target="#modal-form" onClick="goDetail(this)" value="'.$list->id.'"><i class="fa fa-nav-icon far fa-plus-square"></i></button>';

            $html .= "<tr>
            <td style='text-align: center;'>".$tbl_aksi."</td>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_return."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_return), 'd-m-Y')."</td>
            <td>".$list->get_invoice->get_customer->nama_customer."</td>
            <td style='text-align: right;'><b>".number_format($list->total_return, 0)."</b></td>
            </tr>";
            $nom++;
            $total+=$list->total_return;
        }
        $html .= "<tr>
            <td colspan='5' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total, )."</b></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_return_penjualan_detail($id)
    {
        $data['head'] = ReturnJualHeadModel::find($id);
        return view('pelaporan.return_jual.detail', $data);
    }

    public function laporan_return_penjualan_print($tgl_1=null, $tgl_2=null, $view_detail=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        $result = ReturnJualHeadModel::whereDate('tgl_return', '>=', $tgl_1)
                        ->whereDate('tgl_return', '<=', $tgl_2)->get();

        $pdf = PDF::loadview('pelaporan.return_jual.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'check_view_detail' => $view_detail
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();

    }

    //laporan hutang
    public function laporan_hutang()
    {
        $data = [
            'allSupplier' => SupplierModel::all()
        ];
        return view('pelaporan.hutang.index', $data);
    }

    public function laporan_hutang_filter(Request $request)
    {
        $supplier = $request->selSupplier;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($supplier==null)
        {
            $ket_supplier = 'Semua Supplier';
            $result = HutangModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_supplier = SupplierModel::find($supplier)->nama_supplier;
            $result = HutangModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->where('supplier_id', $supplier)
                            ->orderby('tgl_bayar', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            $ket = ($list->metode_bayar==1) ? 'Tunai' : 'Transfer';
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_bayar."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_bayar), 'd-m-Y')."</td>
            <td>".$list->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'><b>".number_format($list->nominal, 0)."</b></td>
            <td style='text-align: center;'>".$ket."</td>
            </tr>";
            $nom++;
            $total+=$list->nominal;
        }
        $html .= "<tr>
            <td colspan='4' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total, )."</b></td>
            <td></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode,
                'supplier' => "Supplier : ".$ket_supplier
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_hutang_print($tgl_1=null, $tgl_2=null, $supplier_id=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        if($supplier_id=='null')
        {
            $ket_supplier = 'Semua Supplier';
            $result = HutangModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_supplier = SupplierModel::find($supplier_id)->nama_supplier;
            $result = HutangModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->where('supplier_id', $supplier_id)
                            ->orderby('tgl_bayar', 'asc')->get();
        }

        $pdf = PDF::loadview('pelaporan.hutang.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'supplier' => $ket_supplier
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    //laporan piutang
    public function laporan_piutang()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('pelaporan.piutang.index', $data);
    }

    public function laporan_piutang_filter(Request $request)
    {
        $customer = $request->selCustomer;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($customer==null)
        {
            $ket_customer = 'Semua Customer';
            $result = PiutangModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_customer = CustomerModel::find($customer)->nama_customer;
            $result = PiutangModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->where('customer_id', $customer)
                            ->orderby('tgl_bayar', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            $ket = ($list->metode_bayar==1) ? 'Tunai' : 'Transfer';
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_bayar."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_bayar), 'd-m-Y')."</td>
            <td>".$list->get_customer->nama_customer."</td>
            <td style='text-align: right;'><b>".number_format($list->nominal, 0)."</b></td>
            <td style='text-align: center;'>".$ket."</td>
            </tr>";
            $nom++;
            $total+=$list->nominal;
        }
        $html .= "<tr>
            <td colspan='4' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total, )."</b></td>
            <td></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode,
                'customer' => "Customer : ".$ket_customer
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_piutang_print($tgl_1=null, $tgl_2=null, $customer_id=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        if($customer_id=='null')
        {
            $ket_customer = 'Semua Customer';
            $result = PiutangModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_customer = CustomerModel::find($customer_id)->nama_customer;
            $result = PiutangModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->where('customer_id', $customer_id)
                            ->orderby('tgl_bayar', 'asc')->get();
        }

        $pdf = PDF::loadview('pelaporan.piutang.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'customer' => $ket_customer
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    //laporan hutang kontainer
    public function laporan_hutang_kontainer()
    {
        $data = [
            'allKontainer' => KontainerModel::all()
        ];
        return view('pelaporan.hutang_kontainer.index', $data);
    }

    public function laporan_hutang_kontainer_filter(Request $request)
    {
        $kontainer = $request->selKontainer;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($kontainer==null)
        {
            $ket_kontainer = 'Semua Kontainer';
            $result = HutangKontainerModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_kontainer = KontainerModel::find($kontainer)->nama_kontainer;
            $result = HutangKontainerModel::whereDate('tgl_bayar', '>=', $tgl_awal)
                            ->whereDate('tgl_bayar', '<=', $tgl_akhir)
                            ->where('kontainer_id', $kontainer)
                            ->orderby('tgl_bayar', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            $ket = ($list->metode_bayar==1) ? 'Tunai' : 'Transfer';
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_bayar."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_bayar), 'd-m-Y')."</td>
            <td>".$list->get_kontainer->nama_kontainer."</td>
            <td style='text-align: right;'><b>".number_format($list->nominal, 0)."</b></td>
            <td style='text-align: center;'>".$ket."</td>
            </tr>";
            $nom++;
            $total+=$list->nominal;
        }
        $html .= "<tr>
            <td colspan='4' style='text-align: right;'><b>TOTAL</b></td>
            <td style='text-align: right;'><b>".number_format($total, )."</b></td>
            <td></td>
        ";
        
        return response()
            ->json([
                'all_result' => $html,
                'periode' => "Periode : ".$request->ket_periode,
                'kontainer' => "Kontainer : ".$ket_kontainer
            ])
            ->withCallback($request->input('callback'));
    }

    public function laporan_hutang_kontainer_print($tgl_1=null, $tgl_2=null, $kontainer_id=null)
    {
        $arr_tgl_1 = explode('-', $tgl_1);
        $ket_tgl_1 = $arr_tgl_1[2]."-".$arr_tgl_1[1]."-".$arr_tgl_1[0];
        $arr_tgl_2 = explode('-', $tgl_2);
        $ket_tgl_2 = $arr_tgl_2[2]."-".$arr_tgl_2[1]."-".$arr_tgl_2[0];
        $ket_periode = $ket_tgl_1." s/d ".$ket_tgl_2;
        
        if($kontainer_id=='null')
        {
            $ket_kontainer = 'Semua Kontainer';
            $result = HutangKontainerModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->orderby('tgl_bayar', 'asc')->get();
        } else {
            $ket_kontainer = KontainerModel::find($kontainer_id)->nama_kontainer;
            $result = HutangKontainerModel::whereDate('tgl_bayar', '>=', $tgl_1)
                            ->whereDate('tgl_bayar', '<=', $tgl_2)
                            ->where('kontainer_id', $kontainer_id)
                            ->orderby('tgl_bayar', 'asc')->get();
        }

        $pdf = PDF::loadview('pelaporan.hutang_kontainer.print', [
            'list_data' => $result,
            'periode' => $ket_periode,
            'kontainer' => $ket_kontainer
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }
}
