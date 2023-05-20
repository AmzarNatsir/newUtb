<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Purchase Order</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="{{asset('assets/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} ">
  <style>
    @page { margin: 30px 40px; }
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
  </style>
</head>
<body>
<table style="width: 100%;">
<tr>
  <td style="width: 50%;"></td>
  <td style="width: 10%; vertical-align: bottom;"><img src="{{ asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" style="width: 120px;  height: auto;"></td>
  <td style="vertical-align: middle;"><h5><strong>PT. USAHA TANI BERSAMA</strong></h5></td>
</tr>
</table>
<table style="font-size: 10pt; width: 100%; border-collapse: collapse;">
<tr>
  <td style="vertical-align: top;">
    <p><strong>Kepada</strong><br>
    <strong>{{ $resHead->get_supplier->nama_supplier }}</strong><br>
    {{ $resHead->get_supplier->alamat }}<br>
    Telp. &nbsp;&nbsp;&nbsp;: {{ $resHead->get_supplier->no_telepon }}<br>
    Email&nbsp;&nbsp;&nbsp;: {{ $resHead->get_supplier->email }}<br>
    </p>
  </td>
  <td style="vertical-align: middle;"><p><strong>Pesanan Pembelian</strong><br>
  No.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{ $resHead->nomor_po }}<br>
  Tanggal&nbsp;&nbsp;&nbsp;&nbsp; : {{ date_format(date_create($resHead->tanggal_po), 'd-m-Y') }}<br>
  </p></td>
</tr>
</table>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;" border='1' cellpadding="3" cellspacing="0">
  <tr>
      <th rowspan="2" class="text-center" style="width: 5%;">No.</th>
      <th colspan="2" class="text-center">Keterangan</th>
      <th rowspan="2" class="text-center" style="width: 15%;">Jumlah Kg</th>
      <th rowspan="2" class="text-center" style="width: 15%;" >Harga Satuan</th>
      <th rowspan="2" class="text-center" style="width: 15%;" >Total</th>
  </tr>
  <tr>
      <th style="width: 30%;" class="text-center">Jenis Pupuk</th>
      <th style="width: 20%;" class="text-center">Merek</th>
  </tr>
  <tbody>
  @php $nom=1 @endphp
  @foreach($resHead->get_detail as $list)
      <tr>
      <td style="height: 30px;" class="text-center">{{ $nom }}</td>
      <td>{{ $list->get_produk->nama_produk }}</td>
      <td>{{ $list->get_produk->get_merk->merk }}</td>
      <td style='text-align: right'>{{ $list->qty }}</td>
      <td style='text-align: right'>{{ number_format($list->harga, 0, ",", ".") }}</td>
      <td style='text-align: right'>{{ number_format($list->sub_total, 0, ",", ".") }}</td>
      </tr>
      @php $nom++ @endphp
  @endforeach
  <tr>
    <td colspan="5" class="text-right"><b>Total Harga</b></td>
    <td style='text-align: right; height:30px'><b>{{ number_format($resHead->total_po, 0, ",", ".") }}</b></td>
  </tr>
  </tbody>
</table>
<table style="font-size: 8pt; width: 100%; border-collapse: collapse;">
  <tr>
    <td style="height: 40px;" colspan="2"></td>
  </tr>
  <tr>
    <td style="width: 70%;">
    <p><strong>Note :</strong><br>
    - Harap pengiriman barang disertakan nota/kwitansi<br>
    - Nomor pesanan pembelian harap dicantumkan dalam nota/kwitansi<br>
    - Barang akan kami kembalikan bila tidak sesuai pesanan<br>
    - Setiap pengiriman barang harap disertakan salinan pesanan pembelian
    </p>
    </td>
    <td class="text-center" style="vertical-align: top;">Disetujui Oleh</td>
  </tr>
  <tr>
    <td style="height: 30px;" colspan="2"></td>
  </tr>
  <tr>
    <td></td>
    <td class="text-center">MUH. HASBI<br>Direktur</td>
  </tr>
</table>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
