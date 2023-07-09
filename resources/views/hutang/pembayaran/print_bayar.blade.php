<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Bukti Pembayaran Hutang</title>
  <link rel="stylesheet" href="{{ asset('assets/AdminLTE/dist/css/adminlte.min.css')}} ">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/> -->
  <style>
    footer { position: fixed; bottom: -20px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
    .trTop {
        border-top: 1pt solid black;
    }
    .trButtom {
        border-bottom: 1pt solid black;
    }
    .trLeft {
        border-left: 1pt solid black;
    }
    .trRight {
        border-right: 1pt solid black;
    }
  </style>
</head>
<body>
<table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
  <tr>
      <td style="width: 50%; vertical-align: middle;">
        <table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;" cellpadding="2">
        <tr>
            <td colspan="3"><h5>BUKTI PEMBAYARAN</h5></td>
        </tr>
        <tr class="trTop trLeft trRight">
            <td style="width: 30%;">Kepada</td>
            <td style="width: 2%;">:</td>
            <td style="width: 50%;">{{ $main->get_supplier->nama_supplier}}</td>
        </tr>
        <tr class="trLeft trRight">
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $main->get_supplier->alamat}}</td>
        </tr>
        <tr class="trLeft trRight">
            <td>Email</td>
            <td>:</td>
            <td>{{ $main->get_supplier->email}}</td>
        </tr>
        <tr class="trButtom trLeft trRight">
            <td>No. Telepon</td>
            <td>:</td>
            <td>{{ $main->get_supplier->no_telepon}}</td>
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
  <tr>
    <td colspan="2" style="height: 30px;"></td>
  </tr>
</table>
<table style="width: 100%; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
    <tr>
        <td colspan="3" rowspan="2" style="height: 30px; vertical-align: middle;">Keterangan : {{ $main->keterangan }}</td>
        <td colspan="2">Nomor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $main->no_bayar }}</td>
    </tr>
    <tr>
        <td colspan="2">Tanggal&nbsp;&nbsp;&nbsp;&nbsp;: {{ date_format(date_create($main->tgl_bayar), 'd-m-Y') }}</td>
    </tr>
    <tr style="background-color: #808080; color:azure">
        <td style="width: 10%; text-align: center;">No. Invoice</td>
        <td style="width: 10%; text-align: center;">Tgl. Invoice</td>
        <td style="width: 10%; text-align: center;">Tgl. JTP</td>
        <td style="width: 10%; text-align: center;">Metode Pembayaran</td>
        <td style="width: 10%; text-align: right;">Nominal&nbsp;</td>
    </tr>
    <tr class="trButtom">
        <td style="text-align: center; height: 40px;">{{ $main->get_receive->no_invoice }}</td>
        <td style="text-align: center;">{{ date_format(date_create($main->get_receive->tgl_invoice), 'd-m-Y') }}</td>
        <td style="text-align: center;">{{ (!empty($main->get_receive->tgl_jatuh_tempo)) ? date_format(date_create($main->get_receive->tgl_jatuh_tempo), 'd-m-Y') : "" }}</td>
        <td style="text-align: center;">{{ ($main->metode_bayar==1) ? 'Tunai' : 'Transfer' }}</td>
        <td style="text-align: right;"><b>{{ number_format($main->nominal, 0) }}&nbsp;</b></td>
    </tr>
</table>
<table style="font-size: 10pt; width: 100%; border-collapse: collapse;">
  <tr>
    <td style="height: 40px;" colspan="2"></td>
  </tr>
  <tr>
    <td style="width: 80%; vertical-align: top;" rowspan="2"></td>
    <td class="text-center" style="vertical-align: top;">Diterima Oleh</td>
  </tr>
  <tr>
    <td  style="height: 60px;"></td>
  </tr>
  <tr>
    <td></td>
    <td class="text-center" style="border-bottom: 1pt solid black"></td>
  </tr>
</table>
</main>

<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
