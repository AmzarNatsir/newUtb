<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\JualHeadModel;
use App\Models\POHeadModel;
use App\Models\ReceiveHeadModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function invoice_po()
    {
        $data = [
            'allSupplier' => SupplierModel::all()
        ];
        return view('invoice.po.index', $data);
    }

    public function invoice_po_filter(Request $request)
    {
        $supplier = $request->selSupplier;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($supplier==null)
        {
            $ket_supplier = 'Semua Supplier';
            $result = POHeadModel::whereDate('tanggal_po', '>=', $tgl_awal)
                            ->whereDate('tanggal_po', '<=', $tgl_akhir)
                            ->orderby('tanggal_po', 'asc')->get();
        } else {
            $ket_supplier = SupplierModel::find($supplier)->nama_supplier;
            $result = POHeadModel::whereDate('tanggal_po', '>=', $tgl_awal)
                            ->whereDate('tanggal_po', '<=', $tgl_akhir)
                            ->where('supplier_id', $supplier)
                            ->orderby('tanggal_po', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            if($list->status_po==1){
                $ket_status = "<span class='badge bg-info'>Approved</span>";
            } else {
                $ket_status = " <span class='badge bg-success'>Received/Close</span>";
            }
            $ket = ($list->metode_bayar==1) ? 'Tunai' : 'Transfer';
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->nomor_po."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tanggal_po), 'd-m-Y')."</td>
            <td>".$list->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'><b>".number_format($list->total_po_net, 0)."</b></td>
            <td>".$ket_status."</td>
            <td style='text-align: center;'><button type='button' class='btn btn-success' value=".$list->id." onClick='goPrint(this)'><i class='fa fa-print'></i></button></td>
            </tr>";
            $nom++;
            $total+=$list->total_po_net;
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

    public function invoice_receiving()
    {
        $data = [
            'allSupplier' => SupplierModel::all()
        ];
        return view('invoice.receiving.index', $data);
    }

    public function invoice_receive_filter(Request $request)
    {
        $supplier = $request->selSupplier;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($supplier==null)
        {
            $ket_supplier = 'Semua Supplier';
            $result = ReceiveHeadModel::whereDate('tanggal_receive', '>=', $tgl_awal)
                            ->whereDate('tanggal_receive', '<=', $tgl_akhir)
                            ->orderby('tanggal_receive', 'asc')->get();
        } else {
            $ket_supplier = SupplierModel::find($supplier)->nama_supplier;
            $result = ReceiveHeadModel::whereDate('tanggal_receive', '>=', $tgl_awal)
                            ->whereDate('tanggal_receive', '<=', $tgl_akhir)
                            ->where('supplier_id', $supplier)
                            ->orderby('tanggal_receive', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            if($list->cara_bayar==1){
                $ket_bayar = "<span class='badge bg-success'>Cash</span>";
            } else {
                $ket_bayar = " <span class='badge bg-danger'>Credit</span>";
            }
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->nomor_receive."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_tiba), 'd-m-Y')."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td>".$list->get_supplier->nama_supplier."</td>
            <td style='text-align: right;'><b>".number_format($list->total_receive_net, 0)."</b></td>
            <td style='text-align: center;'>".$ket_bayar."</td>
            <td style='text-align: center;'><button type='button' class='btn btn-success' value=".$list->id." onClick='goPrint(this)'><i class='fa fa-print'></i></button></td>
            </tr>";
            $nom++;
            $total+=$list->total_receive_net;
        }
        $html .= "<tr>
            <td colspan='5' style='text-align: right;'><b>TOTAL</b></td>
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

    public function invoice_receiving_print($invoice_id)
    {
        $result = ReceiveHeadModel::find($invoice_id);
        
        $pdf = PDF::loadview('invoice.receiving.print', [
            'main' => $result
        ])->setPaper('A4', "Potrait");
        return $pdf->stream();

    }

    public function invoice_penjualan()
    {
        $data = [
            'allCustomer' => CustomerModel::all()
        ];
        return view('invoice.penjualan.index', $data);
    }

    public function invoice_penjualan_filter(Request $request)
    {
        $customer = $request->selCustomer;
        $tgl_awal = $request->tgl_1;
        $tgl_akhir = $request->tgl_2;

        if($customer==null)
        {
            $ket_customer = 'Semua Customer';
            $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->where('status_approval', 1)
                            ->orderby('tgl_transaksi', 'asc')->get();
        } else {
            $ket_customer = CustomerModel::find($customer)->nama_supplier;
            $result = JualHeadModel::whereDate('tgl_transaksi', '>=', $tgl_awal)
                            ->whereDate('tgl_transaksi', '<=', $tgl_akhir)
                            ->whereNull('jenis_jual')
                            ->where('status_approval', 1)
                            ->where('customer_id', $customer)
                            ->orderby('tgl_transaksi', 'asc')->get();
        }
        
        $nom=1;
        $total = 0;
        $html="";
        foreach($result as $list)
        {
            if($list->bayar_via==1){
                $ket_bayar = "<span class='badge bg-success'>Cash</span>";
            } else {
                $ket_bayar = " <span class='badge bg-danger'>Credit</span>";
            }
            $html .= "<tr>
            <td style='text-align: center;'>".$nom."</td>
            <td style='text-align: center;'>".$list->no_invoice."</td>
            <td style='text-align: center;'>".date_format(date_create($list->tgl_invoice), 'd-m-Y')."</td>
            <td>".$list->get_customer->nama_customer."</td>
            <td style='text-align: right;'><b>".number_format($list->total_invoice_net, 0)."</b></td>
            <td style='text-align: center;'>".$ket_bayar."</td>
            <td style='text-align: center;'><button type='button' class='btn btn-success' value=".$list->id." onClick='goPrint(this)'><i class='fa fa-print'></i></button></td>
            </tr>";
            $nom++;
            $total+=$list->total_invoice_net;
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
}
