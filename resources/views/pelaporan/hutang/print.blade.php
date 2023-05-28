<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Pembayaran Hutang</title>
  <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} ">
  <style>
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
<main style="margin-top: -80px;">
<table style="width: 100%;">
<tr>
    <td style="text-align: left;">
        <h5>LAPORAN PEMBAYARAN HUTANG</h5>
        <span class='badge bg-success' style='font-size: 8pt; text-align: left'>Periode : {{ $periode }}<br><br>Supplier : {{ $supplier }}</span>
    </td>
</tr>
</table>
<br>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 30px">No.</th>
        <th style="width: 10%; text-align: center;">No.Bayar</th>
        <th style="width: 10%; text-align: center;">Tgl.Bayar</th>
        <th>Supplier</th>
        <th style="width: 15%; text-align: center;">Nominal (Rp)</th>
        <th style="width: 15%; text-align: left;">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @php 
    $no_urut=1;
    $total=0;  @endphp
    @foreach($list_data as $list)
    <tr>
        <td style='text-align: center; height: 25px;'>{{ $no_urut }}</td>
        <td style='text-align: center;'>{{ $list->no_bayar }}</td>
        <td style='text-align: center;'>{{ date_format(date_create($list->tgl_bayar), 'd-m-Y') }}</td>
        <td>{{ $list->get_supplier->nama_supplier }}</td>
        <td style='text-align: right;'><b>{{ number_format($list->nominal, 0, ",", ".") }}</b></td>
        <td style='text-align: center;'>{{ ($list->metode_bayar==1) ? 'Tunai' : 'Transfer' }}</td>
    </tr>
    @php 
    $no_urut++;
    $total+=$list->nominal; @endphp
    @endforeach
    <tr style="background-color: #808080; color:azure">
        <td colspan="4" class="text-right"><b>TOTAL</b></td>
        <td style='text-align: right; height:30px'><b>{{ number_format($total, 0, ",", ".") }}</b></td>
        <td></td>
    </tr>
    </tbody>
</table>
</main>

<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
