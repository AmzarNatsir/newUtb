<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Stok</title>
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
        <h5>LAPORAN STOK</h5>
        <p <span class='badge bg-success' style='font-size: 9pt;'>Periode : {{ $periode }}</p>
    </td>
</tr>
</table>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;" border="1">
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 30px" rowspan="2">No.</th>
        <th style="width: 10%; text-align: center;" rowspan="2">Kode</th>
        <th rowspan="2">Nama Produk</th>
        <th style="width: 12%; text-align: center;" rowspan="2">Harga Barang</th>
        <th style="width: 8%; text-align: center;" rowspan="2">Stok Awal</th>
        <th style="text-align: center;" colspan="2">Mutasi</th>
        <th style="text-align: center;" colspan="2">Batal</th>
        <th style="width: 8%; text-align: center;" rowspan="2">Stok Akhir</th>
    </tr>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 8%; text-align: center;">Masuk</th>
        <th style="width: 8%; text-align: center;">Keluar</th>
        <th style="width: 8%; text-align: center;">Masuk</th>
        <th style="width: 8%; text-align: center;">Keluar</th>
    </tr>
    </thead>
    <tbody>
    @php 
    $t_stok_awal=0;
    $t_harga=0;
    $t_stok_masuk=0;
    $t_stok_keluar=0;
    $t_stok_akhir=0;
    $t_stok_beli_cancel=0;
    $t_stok_jual_cancel=0;
    @endphp
    @foreach($list_data as $list)
    <tr>
        <td style='text-align: center; height: 25px;'>{{ $list['no_urut'] }}</td>
        <td style='text-align: center;'>{{ $list['kode'] }}</td>
        <td>{{ $list['nama_produk'] }}</td>
        <td style='text-align: right;'>{{ number_format($list['harga_jual'], 0) }}&nbsp;</td>
        <td style='text-align: center;'>{{ number_format($list['stok_awal'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_masuk'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_keluar'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['beli_cancel'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['jual_cancel'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_akhir'], 0) }}</td>
    </tr>";
    @php 
    $t_stok_awal+=$list['stok_awal'];
    $t_harga+=$list['harga_jual'];
    $t_stok_masuk+=$list['stok_masuk'];
    $t_stok_keluar+=$list['stok_keluar'];
    $t_stok_akhir+=$list['stok_akhir'];
    $t_stok_beli_cancel+=$list['beli_cancel'];
    $t_stok_jual_cancel+=$list['jual_cancel'];
    @endphp
    @endforeach
    <tr style="background-color: #808080; color:azure">
        <td colspan="3" class="text-center" style="height: 30px"><b>TOTAL</b></td>
        <td class="text-right"><b>{{ number_format($t_harga, 0) }}&nbsp;</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_awal, 0) }}</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_masuk, 0) }}</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_keluar, 0) }}</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_beli_cancel, 0) }}</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_jual_cancel, 0) }}</b></td>
        <td class="text-center"><b>{{ number_format($t_stok_akhir, 0) }}</b></td>
    </tr>
    </tbody>
    
    </table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
