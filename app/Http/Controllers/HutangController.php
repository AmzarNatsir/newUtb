<?php

namespace App\Http\Controllers;

use App\Models\HutangModel;
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
        $result = ReceiveHeadModel::where('supplier_id', $id_supplier)->where('cara_bayar', 2)->get();
        // dd($result);
        $total_terbayar = \DB::table('hutang')
                                ->join('receive_head', 'receive_head.id', '=', 'hutang.receive_id')
                                ->where('receive_head.supplier_id', $id_supplier)
                                ->whereNull('hutang.deleted_at')
                                ->selectRaw('sum(hutang.nominal) as t_nominal')
                                ->pluck('t_nominal')->first();

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
                'totalHutang' => number_format($total_hutang, 0),
                'totalTerbayar' => number_format($total_terbayar, 0),
                'sisaOutstanding' => number_format($total_hutang - $total_terbayar, 0)
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

}
