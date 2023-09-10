<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Pemberian Sampel</title>
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
        <h5>LAPORAN PENJUALAN</h5>
        <p <span class='badge bg-success' style='font-size: 9pt;'>Periode : {{ $periode }}</p>
    </td>
</tr>
</table>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 30px">No.</th>
        <th style="width: 10%; text-align: center;">Tgl.Invoice</th>
        <th>Customer</th>
        <th style="width: 15%; text-align: center;">Total Produk</th>
        <th style="width: 40%; text-align: center;">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @php
    $no_urut=1;
    $total=0;
    $total_qty_return=0;  @endphp
    @foreach($list_data as $list)
        @php
        $tot_qty = $list->get_detail->sum('qty');
        $tot_qty_return = $list->get_detail->sum('qty_return');
        @endphp
        @if($check_view_detail=='true')
        <tr style="background-color: #e0dfde; color:black">
        @else
        <tr>
        @endif
            <td style='text-align: center; height: 25px;'>{{ $no_urut }}</td>
            <td style='text-align: center;'>{{ date_format(date_create($list->tgl_invoice), 'd-m-Y') }}</td>
            <td>{{ $list->get_customer->nama_customer }}</td>
            <td style='text-align: center;'>{{ $tot_qty }}</td>
            <td>{{ $list->keterangan }}</td>
        </tr>
        @if($check_view_detail=='true')
        <tr>
            <td colspan="5">
            <table class="table-bordered table-vcenter" style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
                <tr>
                    <th style="text-align: center; width: 5%;">#</th>
                    <th style="text-align: center; width: 20%;">Kode</th>
                    <th>Nama Produk</th>
                    <th style="text-align: center; width: 15%;">Kemasan</th>
                    <th style="text-align: center; width: 10%">Qty</th>
                    <th style="text-align: center; width: 10%; color:red">Return</th>
                </tr>
                <tbody>
                @php $nom=1; @endphp
                @foreach($list->get_detail as $det)
                    <tr>
                    <td style="text-align: center;">{{ $nom }}</td>
                    <td style="text-align: center;">{{ $det->get_produk->kode }}</td>
                    <td>{{ $det->get_produk->nama_produk }}</td>
                    <td style='text-align: center'>{{ $det->get_produk->kemasan }} {{ $det->get_produk->get_unit->unit }}</td>
                    <td style='text-align: center'>{{ number_format($det->qty, 0) }}</td>
                    <td style='text-align: center; color:red'>{{ number_format($det->qty_return, 0) }}</td>
                    </tr>
                    @php $nom++ @endphp
                @endforeach

                <tr><td colspan="6">&nbsp;</td></tr>
                </tbody>
            </table>
            </td>
        </tr>
        @endif
    @php
    $total+=$tot_qty;
    $total_qty_return+=$tot_qty_return; @endphp
    @endforeach
</table>
<table class="table-bordered table-vcenter" style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
    <tr>
        <td style='text-align: right; width: 90%'><b>TOTAL PEMBERIAN SAMPLE</b>&nbsp;&nbsp;</td>
        <td style='text-align: left;'><b>&nbsp;&nbsp;{{ $total }}</b></td>
    </tr>
    <tr>
        <td style='text-align: right; color:red'><b>TOTAL RETURN</b>&nbsp;&nbsp;</td>
        <td style='text-align: left; color:red'><b>&nbsp;&nbsp;{{ $total_qty_return }}</b></td>
    </tr>
    <tr>
        <td style='text-align: right; color:green'><b>NET</b>&nbsp;&nbsp;</td>
        <td style='text-align: left; color:green'><b>&nbsp;&nbsp;{{ $total - $total_qty_return }}</b></td>
    </tr>
    </tbody>
</table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
