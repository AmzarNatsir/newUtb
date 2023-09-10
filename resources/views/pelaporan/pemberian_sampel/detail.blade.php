<div class="modal-header">
    <h4 class="modal-title">Detail Pemberian Sampel</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body table-responsive">
    <table class="table table-bordered table-hover" style="width: 100%;">
    <thead>
        <tr>
            <th style="width: 50%;">Tgl. Invoice : {{ $head->tgl_invoice }}</th>
            <th>Customer : {{ $head->get_customer->nama_customer }}</th>
        </tr>
    </thead>
    </table>
    <br>
    <table class="table-bordered table-vcenter" style="font-size: 12pt; width: 100%;">
        <tr>
            <th class="text-center" style="width: 2%;">#</th>
            <th class="text-center" style="width: 15%;">Kode</th>
            <th>Nama Produk</th>
            <th class="text-center" style="width: 10%">Kemasan</th>
            <th class="text-center" style="width: 10%">Qty</th>
            <th class="text-center" style="width: 10%; color:red">Return</th>
        </tr>
        <tbody>
            @php
            $nom=1;
            $total_qty=0;
            $total_qty_return=0;
            @endphp
            @foreach($all_detail as $det)
            <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }}</td>
                <td>{{ $det->get_produk->nama_produk }}</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }} {{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{  number_format($det->qty, 0) }}</td>
                <td style='text-align: center; color:red'>{{ number_format($det->qty_return, 0) }}</td>
            </tr>
            @php
            $nom++;
            $total_qty+=$det->qty;
            $total_qty_return+=$det->qty_return;
            @endphp
            @endforeach
            <tr style="background-color: gray; color: white;">
                <td colspan='4' style='text-align: right'><b>TOTAL</b></td>
                <td style='text-align: center'><b>{{ number_format($total_qty, 0) }}</b></td>
                <td style='text-align: center'><b>{{ number_format($total_qty_return, 0) }}</b></td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
</div>
