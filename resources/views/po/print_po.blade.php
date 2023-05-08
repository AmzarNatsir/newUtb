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
    @page { margin: 40px 40px; }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
  </style>
</head>
<body>
<table style="width: 100%;">
<tr>
  <td style="width: 10%;"><img src="{{ asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" style="width: 100px;  height: auto;"></td>
  <td style="width: 50%;"><h1>Purchase Order</h1></td>
  <td><span class='badge' style="text-align: left;">
          <strong>PT. Usaha Tani Bersama</strong><br>
          Jl. <br>
          Kendari, Sulawesi Tenggara, Indonesia
          </span>
  </td>
</tr>
</table>
<table style="font-size: 10pt; width: 100%; border-collapse: collapse;">
<tr>
  <td style="width: 50%; height: 35px;"><strong>Nomor # {{ $resHead->nomor_po }}</strong></td>
  <td><strong>Tanggal : {{ date_format(date_create($resHead->tanggal_po), 'd-m-Y') }}</strong></td>
</tr>
<tr style="background-color: #eaedf1">
  <td style="height: 30px;"><strong>SUPPLIER</strong></td>
  <td><strong>KETERANGAN</strong></td>
</tr>
<tr>
  <td style="vertical-align: top;">
    <p>{{ $resHead->get_supplier->nama_supplier }}<br>
    {{ $resHead->get_supplier->alamat }}</p>
  </td>
  <td style="vertical-align: top;"><p>{{ $resHead->keterangan }}<br></td>
</tr>
</table>
<table class="table-bordered table-vcenter"style="font-size: 8pt; width: 100%;">
  <tr>
      <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
      <th rowspan="2" style="vertical-align: middle; width: 15%;">Kode</th>
      <th rowspan="2" style="vertical-align: middle;">Nama Produk</th>
      <th colspan="3" class="text-center">Satuan</th>
      <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total</th>
      <th rowspan="2" class="text-right" style="width: 12%;vertical-align: middle;">Sub Total Net</th>
  </tr>
  <tr>
      <th class="text-center" style="width: 10%">Satuan</th>
      <th class="text-center" style="width: 5%">Qty</th>
      <th class="text-center" style="width: 12%">Harga Satuan</th>
  </tr>
  <tbody>
  @php $nom=1 @endphp
  @foreach($resHead->get_detail as $list)
      <tr>
      <td style="height: 30px;">{{ $nom }}</td>
      <td>{{ $list->get_produk->kode }}</td>
      <td>{{ $list->get_produk->nama_produk }}</td>
      <td style='text-align: center'>{{ $list->get_produk->get_unit->unit }}</td>
      <td style='text-align: center'>{{ $list->qty }}</td>
      <td style='text-align: right'>{{ number_format($list->harga, 0, ",", ".") }}</td>
      <td style='text-align: right'>{{ number_format($list->sub_total, 0, ",", ".") }}</td>
      <td style='text-align: right'>{{ number_format($list->sub_total, 0, ",", ".") }}</td>
      </tr>
      @php $nom++ @endphp
  @endforeach
  <tr style="background-color: #eaedf1">
    <td colspan="7" class="text-right"><b>TOTAL</b></td>
    <td style='text-align: right; height:30px'><b>{{ number_format($resHead->total_po, 0, ",", ".") }}</b></td>
  </tr>
  <tr style="background-color: #eaedf1">
    <td colspan="7" class="text-right"><b>DISKON (RP)</b></td>
    <td style='text-align: right; height:30px'><b>{{ number_format($resHead->diskon_rupiah, 0, ",", ".") }}</b></td>
  </tr>
  <tr style="background-color: #eaedf1">
    <td colspan="7" class="text-right"><b>PPN (RP)</b></td>
    <td style='text-align: right; height:30px'><b>{{ number_format($resHead->ppn_rupiah, 0, ",", ".") }}</b></td>
  </tr>
  <tr style="background-color: #eaedf1">
    <td colspan="7" class="text-right"><b>TOTAL NET</b></td>
    <td style='text-align: right; height:30px'><b>{{ number_format($resHead->total_po_net, 0, ",", ".") }}</b></td>
  </tr>
  </tbody>
</table>
<footer><div class="dropdown-divider"></div><div class="text-right"><span class='badge bg-info' style='font-size: 8pt;'>&copy;{{ date("d/m/Y H:s") }}</span></div></footer>
</body>
</html>
