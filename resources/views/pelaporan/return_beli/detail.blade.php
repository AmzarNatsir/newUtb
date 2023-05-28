<div class="modal-header">
    <h4 class="modal-title">Detail Return Pembelian</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <table class="table table-bordered table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 50%;">No. Return : {{ $head->no_return }}</th>
            <th>Supplier : {{ $head->get_receive->get_supplier->nama_supplier }}</th>
        </tr>
        <tr>
            <th style="width: 50%;">Tgl. Return : {{ date_format(date_create($head->tgl_return), 'd-m-Y')  }}</th>
            <th>No. Receive : {{ $head->get_receive->nomor_receive }}</th>
        </tr>
    </thead>
    </table>
    <table class="table table-bordered table-vcenter table-responsive" style="font-size: 12pt; width: 100%;">
    <tr>
            <th class="text-center" style="width: 2%;">#</th>
            <th class="text-center" style="width: 15%;">Kode</th>
            <th>Nama Produk</th>
            <th class="text-center" style="width: 5%">Kemasan</th>
            <th class="text-center">Satuan</th>
            <th class="text-center" style="width: 5%">Qty</th>
            <th class="text-right" style="width: 12%">Harga Satuan</th>
            <th class="text-right" style="width: 12%;" >Sub Total</th>
        </tr>
        <tbody>
            @php
            $nom=1;
            $total_qty=0;
            $total_harga=0;
            $total_subtotal=0;
            @endphp
            @foreach($head->get_detail as $det)
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }}</td>
                <td>{{ $det->get_produk->nama_produk }}</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }}</td>
                <td style='text-align: center'>{{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{ $det->qty }}</td>
                <td style='text-align: right'>{{ number_format($det->harga, 0) }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total, 0) }}</td>
            </tr>
            @php
            $nom++;
            $total_qty+=$det->qty;
            $total_harga+=$det->harga;
            $total_subtotal+=$det->sub_total;
            @endphp
            @endforeach
            <tr style="background-color: gray; color: white;">
                <td colspan='5' style='text-align: right'><b>TOTAL</b></td>
                <td style='text-align: center'><b>{{ $total_qty }}</b></td>
                <td style='text-align: right'><b>{{ number_format($total_harga, 0) }}</b></td>
                <td style='text-align: right'><b>{{ number_format($total_subtotal, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
</div>
