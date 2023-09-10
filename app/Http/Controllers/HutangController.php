<?php

namespace App\Http\Controllers;

use App\Models\HutangKontainerModel;
use App\Models\HutangModel;
use App\Models\KontainerModel;
use App\Models\ReceiveHeadModel;
use App\Models\SupplierModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDF;

class HutangController extends Controller
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
            'allSupplier' => SupplierModel::all()
        ];
        return view('hutang.pembayaran.index', $data);
    }

    public function filter(Request $request)
    {
        $html = "";
        $total_invoice = 0;
        $total_hutang = 0;
        $id_supplier = $request->supplier;
        $result = ReceiveHeadModel::where('kontainer_id', $id_supplier)->where('cara_bayar', 2)->whereNull('status_hutang')->get();
        // dd($result);
        $total_terbayar = \DB::table('hutang')
                                ->join('receive_head', 'receive_head.id', '=', 'hutang.receive_id')
                                ->where('receive_head.kontainer_id', $id_supplier)
                                ->whereNull('hutang.deleted_at')
                                ->selectRaw('sum(hutang.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();

        $total_terhutang = \DB::table('receive_head')
                                ->where('receive_head.kontainer_id', $id_supplier)
                                ->whereNull('receive_head.deleted_at')
                                ->selectRaw('sum(receive_head.total_receive_net) as t_hutang')
                                ->pluck('t_hutang')->first();

        foreach($result as $list)
        {
            $total_terbayar_invoice = \DB::table('hutang')
                                ->where('hutang.receive_id', $list->id)
                                ->whereNull('hutang.deleted_at')
                                ->selectRaw('sum(hutang.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();
            $html .= '<div class="timeline">
                <div>
                    <i class="fas fa-clock bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-calendar"></i> JTP : '.date_format(date_create($list->tgl_jatuh_tempo), "d-m-Y").'</span>
                        <h3 class="timeline-header">No. '.$list->no_invoice.'</h3>

                        <div class="timeline-body">
                            <table  style="font-size: 10pt; width: 100%;" id="table_list_invoice">
                                <tr>
                                    <td style="width: 30%;">Tgl.Invoice</td>
                                    <td style="width: 70%;">: '.date_format(date_create($list->tgl_invoice), "d-m-Y").'</td>
                                </tr>
                                <tr>
                                    <td>Total Invoice</td>
                                    <td style="text-align: right"><b>: Rp. '.number_format($list->total_receive_net, 0).'</b></td>
                                </tr>
                                <tr>
                                    <td>Total Terbayar</td>
                                    <td style="text-align: right"><b>: Rp. '.number_format($total_terbayar_invoice, 0).'</b></td>
                                </tr>
                                <tr>
                                    <td>Outstanding</td>
                                    <td style="text-align: right"><b>: Rp. '.number_format($list->total_receive_net - $total_terbayar_invoice, 0).'</b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="timeline-footer">
                            <button type="button" class="btn btn-primary btn-sm tbl_mutasi" data-toggle="modal" data-target="#modal-form" onclick="goMutasi('.$list->id.')">Mutasi</button>';
                            if($total_terbayar_invoice == $list->total_receive_net)
                            {
                                $html .= ' <button type="button" class="btn btn-warning btn-sm">Lunas</button>';
                            } else {
                                $html .= ' <button type="button" class="btn btn-success btn-sm tbl_bayar" onclick="goBayar('.$list->id.')">Bayar</button>
                                <button class="btn btn-danger btn-sm" type="button" id="loaderDiv2" style="display: none">
                                    <i class="fa fa-asterisk fa-spin text-info"></i>
                                </button>';
                            }
                        $html .= '</div>
                    </div>
                </div>
            </div>';
            $total_invoice++;
            $total_hutang+=$list->total_receive_net;
        }
        return response()
            ->json([
                'all_result' => $html,
                'totalInvoice' => $total_invoice,
                'totalHutang' => number_format($total_terhutang, 0),
                'totalTerbayar' => number_format($total_terbayar, 0),
                'sisaOutstanding' => number_format(($total_hutang - $total_terbayar), 0)
            ])
            ->withCallback($request->input('callback'));
    }

    public function bayar(Request $request)
    {
        $result = ReceiveHeadModel::find($request->id_receive);
        $total_terbayar_invoice = \DB::table('hutang')
            ->where('hutang.receive_id', $request->id_receive)
            ->whereNull('hutang.deleted_at')
            ->selectRaw('sum(hutang.nominal) as t_nominal')
            ->pluck('t_nominal')->first();
        return response()
            ->json([
                'id_receive' => $result->id,
                'nama_supplier' => $result->get_supplier->nama_supplier,
                'no_invoice' => $result->no_invoice,
                'total_invoice_net' => $result->total_receive_net,
                'total_terhutang' => $result->total_receive_net - $total_terbayar_invoice
            ])
            ->withCallback($request->input('callback'));

    }

    public function bayar_store(Request $request)
    {
        try {
            $save = new HutangModel();
            //store header
            $save->no_bayar = $this->create_no_bayar();
            $save->tgl_bayar = ($request->inpTglBayar=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglBayar)));
            $save->receive_id = $request->id_receive;
            $save->supplier_id = $request->sel_supplier;
            $save->metode_bayar = $request->selCaraBayar;
            $save->nominal = str_replace(",","", $request->inpBayar);
            $save->keterangan = $request->inpKeterangan;
            $save->user_id = auth()->user()->id;
            $save->save();
            $total_invoice = str_replace(",","", $request->inpTotalInvoice);
            $total_terbayar_invoice = \DB::table('hutang')
                                ->where('hutang.receive_id', $request->id_receive)
                                ->whereNull('hutang.deleted_at')
                                ->selectRaw('sum(hutang.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();
            $selisih_hutang = $total_invoice - $total_terbayar_invoice;
            if($selisih_hutang==0)
            {
                $update = ReceiveHeadModel::find($request->id_receive);
                $update->status_hutang = 1;
                $exec = $update->save();
            }
            if($save)
            {
                return redirect('pembayaranHutang')->with('message', 'Pembayaran Hutang berhasil disimpan');
            } else {
                return redirect('pembayaranHutang')->with('message', 'Pembayaran Hutang gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('pembayaranHutang')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_bayar()
    {
        $no_urut = 1;
        $kd="HT";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');

        $result = HutangModel::whereYear('tgl_bayar', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_bayar)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut);
        } else {
            $no_trans_baru = (int)substr($result->no_bayar, 9, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

    public function mutasi($id_receiving=null)
    {
        $data = [
            'main' => ReceiveHeadModel::find($id_receiving),
            'list_bayar' => HutangModel::where('receive_id', $id_receiving)->orderby('tgl_bayar', 'asc')->get(),
            'id_receiving' => $id_receiving
        ];
        return view('hutang.daftar.mutasi', $data);
    }

    public function mutasi_print($id_receiving=null)
    {
        $pdf = PDF::loadview('hutang.daftar.print_mutasi', [
            'main' => ReceiveHeadModel::find($id_receiving),
            'list_bayar' => HutangModel::where('receive_id', $id_receiving)->orderby('tgl_bayar', 'asc')->get()
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    //pembayaran hutang kontainer
    public function hutang_kontainer()
    {
        $data = [
            'allKontainer' => KontainerModel::all()
        ];
        return view('hutang.kontainer.index', $data);
    }

    public function hutang_kontainer_filter(Request $request)
    {
        $html = "";
        $total_invoice = 0;
        $total_hutang = 0;
        $nom=1;
        $id_kontainer = $request->kontainer;
        $result = ReceiveHeadModel::where('kontainer_id', $id_kontainer)->whereNull('status_hutang_kontainer')->get();
        $total_terbayar = \DB::table('hutang_kontainer')
                                ->join('receive_head', 'receive_head.id', '=', 'hutang_kontainer.receive_id')
                                ->where('receive_head.kontainer_id', $id_kontainer)
                                ->whereNull('hutang_kontainer.deleted_at')
                                ->selectRaw('sum(hutang_kontainer.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();

        foreach($result as $list)
        {
            $total_terbayar_invoice = \DB::table('hutang_kontainer')
                                ->where('hutang_kontainer.receive_id', $list->id)
                                ->whereNull('hutang_kontainer.deleted_at')
                                ->selectRaw('sum(hutang_kontainer.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();
            $html .= '<tr>
            <td>'.$nom.'</td>
            <td>'.$list->invoice_kontainer.'</td>
            <td>'.date_format(date_create($list->tgl_tiba), "d-m-Y").'</td>
            <td style="text-align: right"><b>'.number_format($list->nilai_kontainer, 0).'</b></td>
            <td style="text-align: right"><span class="float-right badge bg-danger" style="font-size: 10pt"><b>'.number_format($list->nilai_kontainer - $total_terbayar_invoice, 0).'</b></span></td>
            <td><button type="button" class="btn btn-primary btn-sm tbl_mutasi" data-toggle="modal" data-target="#modal-form" onclick="goMutasi('.$list->id.')">Mutasi</button>';
            if($total_terbayar_invoice == $list->nilai_kontainer)
            {
                $html .= ' <button type="button" class="btn btn-warning btn-sm">Lunas</button>';
            } else {
                $html .= ' <button type="button" class="btn btn-success btn-sm tbl_bayar" onclick="goBayar('.$list->id.')">Bayar</button>
                <button class="btn btn-danger btn-sm" type="button" id="loaderDiv2" style="display: none">
                    <i class="fa fa-asterisk fa-spin text-info"></i>
                </button>';
            }

            $html .= '</tr>';
            $total_invoice++;
            $nom++;
            $total_hutang+=$list->nilai_kontainer;
        }
        return response()
            ->json([
                'all_result' => $html,
                'totalInvoice' => $total_invoice,
                'totalHutang' => number_format($total_hutang, 0),
                'totalTerbayar' => number_format($total_terbayar, 0),
                'sisaOutstanding' => number_format($total_hutang - $total_terbayar, 0)
            ])
            ->withCallback($request->input('callback'));
    }

    public function hutang_kontainer_bayar(Request $request)
    {
        $result = ReceiveHeadModel::find($request->id_receive);
        $total_terbayar_invoice = \DB::table('hutang_kontainer')
            ->where('hutang_kontainer.receive_id', $request->id_receive)
            ->whereNull('hutang_kontainer.deleted_at')
            ->selectRaw('sum(hutang_kontainer.nominal) as t_nominal')
            ->pluck('t_nominal')->first();
        return response()
            ->json([
                'id_receive' => $result->id,
                'nama_kontainer' => $result->get_kontainer->nama_kontainer,
                'no_invoice' => $result->invoice_kontainer,
                'total_invoice_net' => $result->nilai_kontainer,
                'total_terhutang' => $result->nilai_kontainer - $total_terbayar_invoice
            ])
            ->withCallback($request->input('callback'));

    }

    public function hutang_kontainer_store(Request $request)
    {
        try {
            $save = new HutangKontainerModel();
            //store header
            $save->no_bayar = $this->create_no_bayar_h_kontainer();
            $save->tgl_bayar = ($request->inpTglBayar=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglBayar)));
            $save->receive_id = $request->id_receive;
            $save->kontainer_id = $request->sel_kontainer;
            $save->metode_bayar = $request->selCaraBayar;
            $save->nominal = str_replace(",","", $request->inpBayar);
            $save->keterangan = $request->inpKeterangan;
            $save->user_id = auth()->user()->id;
            $save->save();

            $total_invoice = str_replace(",","", $request->inpTotalInvoice);
            $total_terbayar_invoice = \DB::table('hutang_kontainer')
                ->where('hutang_kontainer.receive_id', $request->id_receive)
                ->whereNull('hutang_kontainer.deleted_at')
                ->selectRaw('sum(hutang_kontainer.nominal) as t_nominal')
                ->pluck('t_nominal')->first();

            $selisih_hutang = $total_invoice - $total_terbayar_invoice;
            if($selisih_hutang==0)
            {
                $update = ReceiveHeadModel::find($request->id_receive);
                $update->status_hutang_kontainer = 1;
                $exec = $update->save();
            }

            if($save)
            {
                return redirect('pembayaranHutangKontainer')->with('message', 'Pembayaran Hutang Kontainer berhasil disimpan');
            } else {
                return redirect('pembayaranHutangKontainer')->with('message', 'Pembayaran Hutang Kontainer gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('pembayaranHutangKontainer')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_bayar_h_kontainer()
    {
        $no_urut = 1;
        $kd="HTC";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');

        $result = HutangKontainerModel::whereYear('tgl_bayar', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_bayar)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut);
        } else {
            $no_trans_baru = (int)substr($result->no_bayar, 10, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

    public function hutang_kontainer_mutasi($id_receiving=null)
    {
        $data = [
            'main' => ReceiveHeadModel::find($id_receiving),
            'list_bayar' => HutangKontainerModel::where('receive_id', $id_receiving)->orderby('tgl_bayar', 'asc')->get(),
            'id_receiving' => $id_receiving
        ];
        return view('hutang.kontainer.mutasi', $data);
    }

    public function hutang_kontainer_mutasi_print($id_receiving=null)
    {
        $pdf = PDF::loadview('hutang.kontainer.print_mutasi', [
            'main' => ReceiveHeadModel::find($id_receiving),
            'list_bayar' => HutangKontainerModel::where('receive_id', $id_receiving)->orderby('tgl_bayar', 'asc')->get()
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    public function hutang_print($id=null)
    {
        $data = HutangModel::find($id);
        $pdf = PDF::loadview('hutang.pembayaran.print_bayar', [
            'main' => $data
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    public function hutang_kontainer_print($id=null)
    {
        $data = HutangKontainerModel::find($id);
        $pdf = PDF::loadview('hutang.kontainer.print_bayar', [
            'main' => $data
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }
}
