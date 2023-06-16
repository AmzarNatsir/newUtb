<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Mutasi Piutang</title>
  <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} ">
  <style>
    @page { margin: 30px 30px; }
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
  </style>
</head>
<body>
<table style="width: 100%;">
<tr>
  <td style="width: 60%;"></td>
  <td style="width: 10%; vertical-align: bottom;"><img src="{{ asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" style="width: 120px;  height: auto;"></td>
  <td style="vertical-align: middle;"><h5><strong>PT. USAHA TANI BERSAMA</strong></h5></td>
</tr>
</table>
<main style="margin-top: -70px;">
<table style="width: 100%;">
<tr>
    <td style="text-align: left;">
        <h5>MUTASI PIUTANG</h5>
    </td>
</tr>
</table>
<table style="font-size: 8pt; width: 100%;">
<thead>
    <tr>
        <td colspan="4" style="height: 30px;"></td>
    </tr>
    <tr>
        <th style="width: 20%;">No. Invoice</th>
        <th style="width: 30%;">: {{ $main->no_invoice }}</th>
        <th style="width: 20%;">Tgl. Invoice</th>
        <th style="width: 30%;">: {{ date_format(date_create($main->tgl_invoice), 'd-m-Y') }}</th>
    </tr>
    <tr>
        <th>Customer</th>
        <th>: {{ $main->get_customer->nama_customer }}</th>
        <th>Jatuh Tempo</th>
        <th>: {{ date_format(date_create($main->tgl_jatuh_tempo), 'd-m-Y') }}</th>
    </tr>
    <tr>
        <td colspan="4" style="height: 30px;"></td>
    </tr>
</thead>
</table>
<table class="table table-striped" style="font-size: 8pt; width: 100%;">
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
            <p><span class='badge bg-success' style='font-size: 10pt;'>LUNAS</p>
            @endif
            </td>
        </tr>
    </tbody>
</table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
