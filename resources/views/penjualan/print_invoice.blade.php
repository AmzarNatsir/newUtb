<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Invoice Penjualan</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/> -->
  <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} ">
  <style>
    @page { margin: 30px 30px; }
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .rectangle {
      height: 50px;
      width: 320px;
      border-top:5px solid #3D3D3D;
        border-right:5px solid #3D3D3D;
        border-bottom:5px solid #3D3D3D;
        border-left:5px solid #3D3D3D;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 20px;
    }
  </style>
</head>
<body>
<table style="width: 100%;">
  <tr>
      <td colspan="2" style="text-align: center;">
          <h3>INVOICE PENJUALAN</h3>
      </td>
  </tr>
  <tr>
      <td style="width: 50%; vertical-align: top;">
      <table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
          <tr>
              <td style="width: 28%;">No. Invoice</td>
              <td style="width: 2%;">:</td>
              <td style="width: 70%;">{{ $dt_head->no_invoice }}</td>
          </tr>
          <tr>
              <td>Tanggal. Inv</td>
              <td>:</td>
              <td>{{ date_format(date_create($dt_head->tgl_invoice), 'd-M-Y') }}</td>
          </tr>
          <tr>
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td>{{ ($dt_head->bayar_via==1) ? '' : date_format(date_create($dt_head->tgl_jatuh_tempo), 'd-M-Y') }}</td>
          </tr>
          <tr>
            <td>Salesman</td>
            <td>:</td>
            <td></td>
          </tr>
          <tr>
              <td>Pembayaran Via</td>
              <td>:</td>
              <td>{{ ($dt_head->bayar_via==1) ? 'Tunai' : 'Kredit' }}</td>
          </tr>
          <tr>
              <td style="vertical-align: top;">Customer</td>
              <td style="vertical-align: top;">:</td>
              <td><b>{{ $dt_head->get_customer->nama_customer }}</b><br>{{ $dt_head->get_customer->alamat }} <br>Kota {{ $dt_head->get_customer->kota }} Telepon {{ $dt_head->get_customer->no_telepon }}</td>
          </tr>
      </table>
      </td>
      <td style="width: 50%;">
          <table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
          <tr>
              <td style="width: 30%;"><img src="{{ asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" style="width: 120px;  height: auto;"></td>
              <td style="width: 70%"><h5><strong>PT. USAHA TANI BERSAMA</strong></h5></td>
          </tr>
          <tr>
              <td colspan="2">Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telepon : 0401-3092867</td>
          </tr></td>
          </tr>
          </table>
      </td>
  </tr>
  </table>
<br>
  <table style="width: 100%; font-size: 9pt; font-family: Arial, Helvetica, sans-serif;  border-collapse: collapse;" border="1" cellpadding="4">
    <tr style="background-color: gray; color: white;">
        <th style="width: 3%; text-align: center;">No</th>
        <th style="text-align: center;">Nama Produk</th>
        <th style="width: 10%; text-align: center;">Kemasan</th>
        <th style="width: 8%; text-align: center;">Qty</th>
        <th style="width: 13%; text-align: center;">Harga</th>
        <th style="width: 13%; text-align: center;" >Sub Total</th>
        <th style="width: 8%; text-align: center;">Diskon</th>
        <th style="width: 13%; text-align: center;" >Sub Total Net</th>
    </tr>
    <tbody>
      @php
      $nom=1;
      $total_qty=0;
      $total_harga=0;
      $total_subtotal=0;
      $total_subtotal_net=0;
      @endphp
      @foreach($dt_head->get_detail as $det)
      <tr>
          <td style="height: 30px;">{{ $nom }}</td>
          <td>{{ $det->get_produk->nama_produk }}</td>
          <td style='text-align: center'>{{ $det->get_produk->kemasan }} {{ $det->get_produk->get_unit->unit }}</td>
          <td style='text-align: center'>{{ $det->qty }}</td>
          <td style='text-align: right'>{{ number_format($det->harga, 0) }}</td>
          <td style='text-align: right'>{{ number_format($det->sub_total, 0) }}</td>
          <td style='text-align: right'>{{ (!empty($det->diskitem_persen)) ? $det->diskitem_persen.' %' : "" }}</td>
          <td style='text-align: right'>{{ number_format($det->sub_total_net, 0) }}</td>
      </tr>
      @php
      $nom++;
      $total_qty+=$det->qty;
      $total_harga+=$det->harga;
      $total_subtotal+=$det->sub_total;
      $total_subtotal_net+=$det->sub_total_net;
      @endphp
      @endforeach
      <tr>
          <td colspan='4' rowspan="6">Pembayaran Via transfer Bank ke : <br>
          <div class="rectangle">Bank BCA <br>an. USAHA TANI BERSAMA <br><h4><b>7245679777</b></h4></div>
          <label style="font-size: smaller;">#Pembayaran kami anggap diterima ketika dana masuk ke Rekeing Kami</label>
          </td>
          <td colspan='2' style='text-align: right'><b>TOTAL</b></td>
          <td colspan='2' style='text-align: right'><b>{{ number_format($dt_head->total_invoice, 0) }}</b></td>
      </tr>
      <tr>
          <td colspan='2' style='text-align: right'><b>DISKON</b></td>
          <td style='text-align: right'>{{ $dt_head->diskon_persen }} %</td>
          <td style='text-align: right'><b>{{ number_format($dt_head->diskon_rupiah, 0) }}</b></td>
      </tr>
      <tr>
          <td colspan='2' style='text-align: right'><b>PPN</b></td>
          <td style='text-align: right'>{{ $dt_head->ppn_persen }} %</td>
          <td style='text-align: right'><b>{{ number_format($dt_head->ppn_rupiah, 0) }}</b></td>
      </tr>
      <tr>
          <td colspan='2' style='text-align: right'><b>ONGKOS KIRIM</b></td>
          <td colspan='2' style='text-align: right'><b>{{ number_format($dt_head->ongkir, 0) }}</b></td>
      </tr>
      <tr style="background-color: gray; color: white;">
          <td colspan='2' style='text-align: right'><b>TOTAL NET</b></td>
          <td colspan='2' style='text-align: right'><b>{{ number_format($dt_head->total_invoice_net, 0) }}</b></td>
      </tr>
      <tr>
        <td colspan="4">
          <table style="width: 100%; font-size: 9pt; font-family: Arial, Helvetica, sans-serif;">
            <tr>
              <td style="width: 50%; border: 1px; border-style: solid; height: 100px; text-align: center"><img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate(url('vqrcode'))) !!} "></td>
              <td style="width: 50%; border: 1px; border-style: solid; height: 100px;"></td>
            </tr>
            <tr>
              <td style="border: 1px; border-style: solid; height: 30px; text-align: center;">PT. USAHA TANI BERSAMA</td>
              <td style="border: 1px; border-style: solid; height: 30px; text-align: center;">{{ strtoupper($dt_head->get_customer->nama_customer) }}</td>
            </tr>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
