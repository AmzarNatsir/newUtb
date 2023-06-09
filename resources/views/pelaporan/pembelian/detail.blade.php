<div class="modal-header">
    <h4 class="modal-title">Detail Pembelian</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    @php
    $arr_via = array('1' => 'Tunai', '2' => 'Kredit');
    if($head->cara_bayar==1) {
        $ket_cara_bayar = "Tunai";
    } else {
        $ket_cara_bayar = "Kredit";
    }
    @endphp
    
    <table class="table table-bordered table-hover" style="width: 100%;">
    <thead>
        <tr>
        <th style="width: 50%;">Receiving Nomor : {{ $head->nomor_receive }} - Tanggal : {{ date_format(date_create($head->tanggal_receive), 'd-m-Y') }}</th>
        <th style="width: 50%;">Invoice Supplier Nomor : {{ $head->no_invoice }} - Tanggal : {{ date_format(date_create($head->tgl_invoice), 'd-m-Y') }}</th>
        </tr>
        <tr>
            <th>Supplier : {{ $head->get_supplier->nama_supplier }}</th>
            <th>Metode Pembayaran : {{ $ket_cara_bayar }}</th>
        </tr>
        <tr>
            <th>Kontainer Nomor : {{ $head->invoice_kontainer }} - Rp. {{ number_format($head->nilai_kontainer, 0) }}</th>
            <th>Tanggal Jatuh Tempo : {{ (!empty($head->tgl_jatuh_tempo)) ? date_format(date_create($head->tgl_jatuh_tempo), 'd-m-Y') : "" }}</th>
        </tr>
    </thead>
    </table>
    <table class="table table-bordered table-vcenter table-responsive" style="font-size: 12pt; width: 100%;">
        <tr>
            <th class="text-center" style="width: 2%;">#</th>
            <th class="text-center" style="width: 10%;">Kode</th>
            <th>Nama Produk</th>
            <th class="text-center" style="width: 5%">Kemasan</th>
            <th class="text-center">Satuan</th>
            <th class="text-center" style="width: 5%">Qty</th>
            <th class="text-right" style="width: 12%">Harga Satuan</th>
            <th class="text-right" style="width: 12%;" >Sub Total</th>
            <th class="text-center" style="width: 5%">Diskon</th>
            <th class="text-right" style="width: 12%;" >Sub Total Net</th>

        </tr>
        <tbody>
            @php
            $nom=1;
            $total_qty=0;
            $total_harga=0;
            $total_subtotal=0;
            $total_subtotal_net=0;
            @endphp
            @foreach($all_detail as $det)
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }}</td>
                <td>{{ $det->get_produk->nama_produk }}</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }}</td>
                <td style='text-align: center'>{{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{ $det->qty }}</td>
                <td style='text-align: right'>{{ number_format($det->harga, 0) }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total, 0) }}</td>
                <td style='text-align: right'>{{ (!empty($det->diskitem_persen)) ? $det->diskitem_persen.' %' : "" }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total_net, 0) }}</td>
            </tr>
            @php
            $nom++;
            @endphp
            @endforeach
            <tr style="background-color: gray; color: white;">
                <td colspan='8' style='text-align: right'><b>TOTAL</b></td>
                <td></td>
                <td style='text-align: right'><b>{{ number_format($head->total_receice, 0) }}</b></td>
            </tr>
            <tr style="background-color: gray; color: white;">
                <td colspan='8' style='text-align: right'><b>DISKON</b></td>
                <td style='text-align: right'><b>{{ $head->diskon_persen }} %</b></td>
                <td style='text-align: right'><b>{{ number_format($head->diskon_rupiah, 0) }}</b></td>
            </tr>
            <tr style="background-color: gray; color: white;">
                <td colspan='8' style='text-align: right'><b>PPN</b></td>
                <td style='text-align: right'><b>{{ $head->ppn_persen }} %</b></td>
                <td style='text-align: right'><b>{{ number_format($head->ppn_rupiah, 0) }}</b></td>
            </tr>
            <tr style="background-color: gray; color: white;">
                <td colspan='8' style='text-align: right'><b>TOTAL NET</b></td>
                <td></td>
                <td style='text-align: right'><b>{{ number_format($head->total_receive_net, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
</div>
