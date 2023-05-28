<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Return Pembelian</title>
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
        <h5>LAPORAN RETURN PEMBELIAN</h5>
        <p <span class='badge bg-success' style='font-size: 9pt;'>Periode : {{ $periode }}</p>
    </td>
</tr>
</table>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 30px">No.</th>
        <th style="width: 10%; text-align: center;">No.Return</th>
        <th style="width: 10%; text-align: center;">Tgl.Return</th>
        <th>Supplier</th>
        <th style="width: 15%; text-align: center;">Total (Rp)</th>
    </tr>
    </thead>
    <tbody>
    @php 
    $no_urut=1;
    $total=0;  @endphp
    @foreach($list_data as $list)
    <tr>
        <td style='text-align: center; height: 25px;'>{{ $no_urut }}</td>
        <td style='text-align: center;'>{{ $list->no_return }}</td>
        <td style='text-align: center;'>{{ $list->tgl_return }}</td>
        <td>{{ $list->get_receive->get_supplier->nama_supplier }}</td>
        <td style='text-align: right;'><b>{{ number_format($list->total_return, 0, ",", ".") }}</b></td>
    </tr>
    @if($check_view_detail=='true')
    <tr>
        <td colspan="5">
        <table class="table-bordered table-vcenter"style="font-size: 8pt; width: 100%;">
            <tr>
                <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
                <th rowspan="2" style="vertical-align: middle;">Nama Produk</th>
                <th colspan="3" class="text-center">Satuan</th>
                <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 10%">Satuan</th>
                <th class="text-center" style="width: 5%">Qty</th>
                <th class="text-center" style="width: 12%">Harga Satuan</th>
            </tr>
            <tbody>
            @php $nom=1 @endphp
            @foreach($list->get_detail as $det)
                <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }} | {{ $det->get_produk->nama_produk }}</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }} {{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{ $det->qty }}</td>
                <td style='text-align: right'>{{ number_format($det->harga, 0, ",", ".") }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total, 0, ",", ".") }}</td>
                </tr>
                @php $nom++ @endphp
            @endforeach
            </tbody>
        </table>
        </td>
    </tr>
    @endif
    @php 
    $no_urut++;
    $total+=$list->sub_total; @endphp
    @endforeach
    <tr style="background-color: #808080; color:azure">
        <td colspan="4" class="text-right"><b>TOTAL</b></td>
        <td style='text-align: right; height:30px'><b>{{ number_format($total, 0, ",", ".") }}</b></td>
    </tr>
    </tbody>
</table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
