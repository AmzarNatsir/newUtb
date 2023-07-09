<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\JualHeadModel;
use App\Models\PiutangModel;
use App\Models\ViaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDF;

class PiutangController extends Controller
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
            'allCustomer' => CustomerModel::all(),
            'allVia' => ViaModel::all()
        ];
        return view('piutang.penerimaan.index', $data);
    }

    public function filter(Request $request)
    {
        $html = "";
        $total_invoice = 0;
        $total_piutang = 0;
        $id_customer = $request->customer;
        $result = JualHeadModel::where('customer_id', $id_customer)->where('bayar_via', 2)->get();
        // dd($result);
        $total_terbayar = \DB::table('piutang')
                                ->join('jual_head', 'jual_head.id', '=', 'piutang.jual_id')
                                ->where('jual_head.customer_id', $id_customer)
                                ->whereNull('piutang.deleted_at')
                                ->selectRaw('sum(piutang.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();

        foreach($result as $list)
        {
            $total_terbayar_invoice = \DB::table('piutang')
                                ->where('piutang.jual_id', $list->id)
                                ->whereNull('piutang.deleted_at')
                                ->selectRaw('sum(piutang.nominal) as t_nominal')
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
                                    <td style="text-align: right"><b>: Rp. '.number_format($list->total_invoice_net, 0).'</b></td>
                                </tr>
                                <tr>
                                    <td>Total Terbayar</td>
                                    <td style="text-align: right"><b>: Rp. '.number_format($total_terbayar_invoice, 0).'</b></td>
                                </tr>
                                <tr>
                                    <td>Outstanding</td>
                                    <td style="text-align: right"><b>: Rp. '.number_format($list->total_invoice_net - $total_terbayar_invoice, 0).'</b></td>
                                </tr>
                            </table>
                        </div>
                        <div class="timeline-footer">
                            <button type="button" class="btn btn-primary btn-sm tbl_mutasi" data-toggle="modal" data-target="#modal-form" onclick="goMutasi('.$list->id.')">Mutasi</button>';
                            if($total_terbayar_invoice == $list->total_invoice_net)
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
            $total_piutang+=$list->total_invoice_net;
        }
        return response()
            ->json([
                'all_result' => $html,
                'totalInvoice' => $total_invoice,
                'totalPiutang' => number_format($total_piutang, 0),
                'totalTerbayar' => number_format($total_terbayar, 0),
                'sisaOutstanding' => number_format($total_piutang - $total_terbayar, 0)
            ])
            ->withCallback($request->input('callback'));
    }

    public function bayar(Request $request)
    {
        $result = JualHeadModel::find($request->id_invoice);
        $total_terbayar_invoice = \DB::table('piutang')
            ->where('piutang.jual_id', $request->id_invoice)
            ->whereNull('piutang.deleted_at')
            ->selectRaw('sum(piutang.nominal) as t_nominal')
            ->pluck('t_nominal')->first();
        return response()
            ->json([
                'id_invoice' => $result->id,
                'nama_customer' => $result->get_customer->nama_customer,
                'no_invoice' => $result->no_invoice,
                'total_invoice_net' => $result->total_invoice_net,
                'total_oustanding' => $result->total_invoice_net - $total_terbayar_invoice
            ])
            ->withCallback($request->input('callback'));
    }

    public function bayar_store(Request $request)
    {
        try {
            $save = new PiutangModel();
            //store header
            $save->no_bayar = $this->create_no_bayar();
            $save->tgl_bayar = ($request->inpTglBayar=="") ? NULL : date("Y-m-d", strtotime(str_replace("/", "-", $request->inpTglBayar)));
            $save->jual_id = $request->id_invoice;
            $save->customer_id = $request->sel_customer;
            $save->metode_bayar = $request->selCaraBayar;
            $save->via_id = $request->sel_via;
            $save->nominal = str_replace(",","", $request->inpBayar);
            $save->keterangan = $request->inpKeterangan;
            $save->user_id = auth()->user()->id;
            $save->save();
            if($save)
            {
                return redirect('penerimaanPiutang')->with('message', 'Pembayaran Piutang berhasil disimpan');
            } else {
                return redirect('penerimaanPiutang')->with('message', 'Pembayaran Piutang gagal disimpan');
            }
        } catch (QueryException $e)
        {
            return redirect('penerimaanPiutang')->with('message', 'Proses Gagal. Pesan Error : '.$e->getMessage());
        }
    }

    public function create_no_bayar()
    {
        $no_urut = 1;
        $kd="PT";
        $bulan = sprintf('%02s', date('m'));
        $tahun = date('Y');
        
        $result = PiutangModel::whereYear('tgl_bayar', $tahun)->orderby('id', 'desc')->first();
        if(empty($result->no_bayar)) {
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_urut); 
        } else {
            $no_trans_baru = (int)substr($result->no_bayar, 9, 4) + 1;
            $no_baru = $kd.$tahun.$bulan.sprintf('%04s', $no_trans_baru);
        }
        return $no_baru;
    }

    public function mutasi($id_invoice=null)
    {
        $data = [
            'main' => JualHeadModel::find($id_invoice),
            'list_bayar' => PiutangModel::where('jual_id', $id_invoice)->orderby('tgl_bayar', 'asc')->get(),
            'id_invoice' => $id_invoice
        ];
        return view('piutang.daftar.mutasi', $data);
    }

    public function mutasi_print($id_invoice=null)
    {
        $pdf = PDF::loadview('piutang.daftar.print_mutasi', [
            'main' => JualHeadModel::find($id_invoice),
            'list_bayar' => PiutangModel::where('jual_id', $id_invoice)->orderby('tgl_bayar', 'asc')->get()
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }

    public function piutang_print($id=null)
    {
        $data = PiutangModel::find($id);
        $pdf = PDF::loadview('piutang.penerimaan.print_bayar', [
            'main' => $data
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();
    }
}
