<div class="modal-header">
    <h4 class="modal-title">Detail Penjualan</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    @php
    if($head->bayar_via==1) {
        $ket_cara_bayar = "Tunai / ".$head->get_via->penerimaan;
        $lbl_bayar = "Metode Pembayaran / Via";
    } else {
        $ket_cara_bayar = "Kredit";
        $lbl_bayar = "Metode Pembayaran";
    }
    @endphp

    <table class="table-bordered table-hover" style="width: 100%;">
    <thead>
        <tr>
        <th style="width: 50%;">No. Invoice : {{ $head->no_invoice }}</th>
        <th style="width: 50%;">Tgl. Invoice : {{ date_format(date_create($head->tgl_transaksi), 'd-m-Y') }}</th>
        </tr>
        <tr>
            <th>Customer : {{ $head->get_customer->nama_customer }}</th>
            <th>{{ $lbl_bayar }} : {{ $ket_cara_bayar }}</th>
        </tr>
    </thead>
    </table>
    <br>
    <table class="table-bordered table-vcenter table-responsive" style="font-size: 11pt; width: 100%;">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="width: 2%;">#</th>
                <th rowspan="2" class="text-center" style="width: 10%;">Kode</th>
                <th rowspan="2">Nama Produk</th>
                <th rowspan="2" class="text-center" style="width: 5%">Kemasan</th>
                <th colspan="5" class="text-center">Penjualan</th>
                <th colspan="2" class="text-center" style="color:red">Return</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 5%">Qty</th>
                <th class="text-right" style="width: 12%">Harga Satuan</th>
                <th class="text-right" style="width: 12%;" >Sub Total</th>
                <th class="text-center" style="width: 5%">Diskon</th>
                <th class="text-right" style="width: 12%;" >Sub Total Net</th>
                <th class="text-center" style="width: 5%; color:red">Qty</th>
                <th class="text-right" style="width: 12%; color:red">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @php
            $nom=1;
            $total_qty=0;
            $total_qty_return=0;
            $total_harga=0;
            $total_subtotal=0;
            $total_subtotal_net=0;
            $total_return=0;
            @endphp
            @foreach($all_detail as $det)
            @php $sub_total_return = $det->harga * $det->qty_return; @endphp
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }}</td>
                <td>{{ $det->get_produk->nama_produk }} ({{ $det->get_sub_produk->nama_produk }})</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }} {{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{ $det->qty }}</td>
                <td style='text-align: right'>{{ number_format($det->harga, 0) }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total, 0) }}</td>
                <td style='text-align: right'>{{ (!empty($det->diskitem_persen)) ? $det->diskitem_persen.' %' : "" }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total_net, 0) }}</td>
                <td style='text-align: center; color:red'>{{ $det->qty_return }}</td>
                <td style='text-align: right; color:red'>{{ number_format($sub_total_return, 0) }}</td>
            </tr>
            @php
            $nom++;
            $total_qty+=$det->qty;
            $total_qty_return+=$det->qty_return;
            $total_harga+=$det->harga;
            $total_subtotal+=$det->sub_total;
            $total_subtotal_net+=$det->sub_total_net;
            $total_return+=$sub_total_return;
            @endphp
            @endforeach
            <tr style="background-color: gray; color: white;">
                <td colspan='4' style='text-align: right'><b>TOTAL</b></td>
                <td style='text-align: center'><b>{{ $total_qty }}</b></td>
                <td style='text-align: right'><b>{{ number_format($total_harga, 0) }}</b></td>
                <td style='text-align: right'><b>{{ number_format($total_subtotal, 0) }}</b></td>
                <td></td>
                <td style='text-align: right'><b>{{ number_format($total_subtotal_net, 0) }}</b></td>
                <td style='text-align: center;'><b>{{ $total_qty_return }}</b></td>
                <td style='text-align: right;'><b>{{ number_format($total_return, 0) }}</b></td>
            </tr>
            <tr>
                <td colspan='6'></td>
                <td colspan="5" style="text-align: center; background: #2fab4a; color:white"><b>SUMMARY</b></td>
            </tr>
            <tr>
                <td colspan='7' style='text-align: right'><b>TOTAL</b></td>
                <td style='text-align: right' colspan="2"><b>{{ number_format($head->total_invoice_net, 0) }}</b></td>
                <td style='text-align: right; color:red' colspan="2"><b>{{ number_format($total_return, 0) }}</b></td>
            </tr>
            <tr>
                <td colspan='7' style='text-align: right'><b>DISKON</b></td>
                <td style='text-align: right'><b>{{ $head->diskon_persen }} %</b></td>
                <td style='text-align: right'><b>{{ number_format($head->diskon_rupiah, 0) }}</b></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan='7' style='text-align: right'><b>PPN</b></td>
                <td style='text-align: right'><b>{{ $head->ppn_persen }} %</b></td>
                <td style='text-align: right'><b>{{ number_format($head->ppn_rupiah, 0) }}</b></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan='7' style='text-align: right'><b>TOTAL NET</b></td>
                <td style='text-align: right' colspan="2"><b>{{ number_format($head->total_invoice_net, 0) }}</b></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan='7' style='text-align: right'><b>NET</b></td>
                <td colspan="2"></td>
                <td style='text-align: right; color:green' colspan="2"><b>{{ number_format($head->total_invoice_net - $total_return, 0) }}</b></td>
            </tr>


        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
</div>
