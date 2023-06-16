<div class="modal-header">
    <h4 class="modal-title">Mutasi Penerimaan Piutang</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <table class="table-bordered table-hover" style="width: 100%;">
        <thead>
            <tr>
                <th style="width: 20%;">No. Invoice</th>
                <th style="width: 30%;">: {{ $main->no_invoice }}</th>
                <th style="width: 20%;">Tgl. Invoice</th>
                <th style="width: 30%;">: {{ date_format(date_create($main->tgl_invoice), 'd-m-Y') }}</th>
            </tr>
            <tr>
                <th>Supplier</th>
                <th>: {{ $main->get_customer->nama_customer }}</th>
                <th>Jatuh Tempo</th>
                <th>: {{ date_format(date_create($main->tgl_jatuh_tempo), 'd-m-Y') }}</th>
            </tr>
        </thead>
        </table>
        <table class="table table-striped">
            <thead style="background-color: #808080; color:azure">
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%; text-align: right;">Nominal</th>
                <th style="width: 20%; text-align: right;">Outstanding</th>
                <th>Keterangan</th>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align: right;"><b>Total Invoice</b></td>
                    <td style="text-align: right;"><b>{{ number_format($main->total_invoice_net, 0) }}</b></td>
                    <td></td>
                </tr>
                @php
                    $nom=1;
                    $n_outs = $main->total_invoice_net;
                @endphp
                @foreach($list_bayar as $list)
                    @php $n_outs-=$list->nominal; @endphp
                <tr>
                    <td>{{ $nom }}</td>
                    <td>{{ date_format(date_create($list->tgl_bayar), 'd-m-Y') }}</td>
                    <td style="text-align: right;">{{ number_format($list->nominal, 0) }}</td>
                    <td style="text-align: right;">{{ number_format($n_outs, 0) }}</td>
                    <td>{{ $list->keterangan }} ({{ ($list->metode_bayar==1) ? "Tunai" : "Transfer" }} / Via : {{ (empty($list->via_id)) ? "" : $list->get_via->penerimaan }})</td>
                </tr>
                @php
                    $nom++;
                @endphp 
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;"><b>Sisa Oustanding</b></td>
                    <td style="text-align: right;"><b>{{ number_format($n_outs, 0) }}</b></td>
                    <td>
                    @if($n_outs==0)    
                    <button type="button" class="btn btn-success float-left" style="margin-right: 5px;"><i class="fas fa-check"></i> LUNAS</button>
                    @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row no-print">
        <div class="col-12">
            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" onclick="goPrintMutasi(this)" value="{{ $main->id }}"><i class="fas fa-download"></i> Print PDF
            </button>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
    </div>
</div>
<script>
    $(function(){});
    var goPrintMutasi = function(el)
    {
        var id_data = $(el).val();
        window.open(route('penerimaanPiutangMutasiPrint', id_data), "_blank");
    }
</script>