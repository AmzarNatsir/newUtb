<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Persediaan Stok</title>
  <!-- <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} "> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    @page { margin: 30px 30px; }
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
  </style>
</head>
<body>
<table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
  <tr>
      <td style="width: 50%; vertical-align: middle;">
        <table style="width: 100%;">
        <tr>
            <td colspan="3"><h6>LAPORAN PERSEDIAAN STOK</h6></td>
        </tr>
        <tr>
            <td style="width: 18%;">Periode</td>
            <td style="width: 2%;">:</td>
            <td style="width: 80%;">{{ $periode }}</td>
        </tr>
        </table>
      </td>
      <td style="width: 50%;">
          <table style="width: 100%;">
          <tr>
              <td style="width: 20%; vertical-align: top;"><img src="{{ asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" style="width: 100px;  height: auto;"></td>
              <td style="width: 80%; font-size: 8pt;"><h6><strong>PT. USAHA TANI BERSAMA</strong></h6><p>Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117 - Telepon : 0401-3092867</p></td>
          </tr>
          </table>
      </td>
  </tr>
</table>
<table style="font-size: 8pt; font-family: Arial, Helvetica, sans-serif; width: 100%; border-collapse: collapse;" border="1" cellpadding='3'>
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 25px" rowspan="2">No.</th>
        <th style="width: 13%; text-align: center;" rowspan="2">Kode</th>
        <th rowspan="2">Nama Produk</th>
        <th style="width: 10%; text-align: center;" rowspan="2">Merk</th>
        <th style="width: 10%; text-align: center;" rowspan="2">Kemasan</th>
        <th style="width: 12%; text-align: center;" rowspan="2">Harga</th>
        <th style="width: 8%; text-align: center;" rowspan="2">Stok Awal</th>
        <th style="text-align: center;" colspan="2">Mutasi</th>
        <th style="width: 8%; text-align: center;" rowspan="2">Stok Akhir</th>
    </tr>
    <tr style="background-color: #808080; color:azure">
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
    @endphp
    @foreach($list_data as $list)
    <tr>
        <td style='text-align: center; height: 25px;'>{{ $list['no_urut'] }}</td>
        <td style='text-align: center;'>{{ $list['kode'] }}</td>
        <td>{{ $list['nama_produk'] }}</td>
        <td style='text-align: center;'>{{ $list['merk'] }}</td>
        <td style='text-align: center;'>{{ $list['kemasan'] }} {{ $list['satuan'] }}</td>
        <td style='text-align: right;'>{{ number_format($list['harga_jual'], 0) }}&nbsp;</td>
        <td style='text-align: center;'>{{ number_format($list['stok_awal'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_masuk'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_keluar'], 0) }}</td>
        <td style='text-align: center;'>{{ number_format($list['stok_akhir'], 0) }}</td>
    </tr>";
    @php 
    $t_stok_awal+=$list['stok_awal'];
    $t_harga+=$list['harga_jual'];
    $t_stok_masuk+=$list['stok_masuk'];
    $t_stok_keluar+=$list['stok_keluar'];
    $t_stok_akhir+=$list['stok_akhir'];
    @endphp
    @endforeach
    <tr style="background-color: #808080; color:azure">
        <td colspan="5" style="height: 30px; text-align: right;"><b>TOTAL</b></td>
        <td style='text-align: right;'><b>{{ number_format($t_harga, 0) }}&nbsp;</b></td>
        <td style='text-align: center;'><b>{{ number_format($t_stok_awal, 0) }}</b></td>
        <td style='text-align: center;'><b>{{ number_format($t_stok_masuk, 0) }}</b></td>
        <td style='text-align: center;'><b>{{ number_format($t_stok_keluar, 0) }}</b></td>
        <td style='text-align: center;'><b>{{ number_format($t_stok_akhir, 0) }}</b></td>
    </tr>
    </tbody>
    
    </table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
