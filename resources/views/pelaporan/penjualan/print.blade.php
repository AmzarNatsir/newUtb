<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UTB | Print Laporan Penjualan</title>
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
            <td colspan="3"><h5>LAPORAN PENJUALAN</h5></td>
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
              <td style="width: 80%"><h5><strong>PT. USAHA TANI BERSAMA</strong></h5><p>Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117 - Telepon : 0401-3092867</p></td>
          </tr>
          </table>
      </td>
  </tr>
</table>
<table style="font-size: 9pt; font-family: Arial, Helvetica, sans-serif; width: 100%; border-collapse: collapse;" border="1">
    <thead>
    <tr style="background-color: #808080; color:azure">
        <th style="width: 5%; text-align: center; height: 30px">No.</th>
        <th style="width: 7%; text-align: center;">Tgl.Invoice</th>
        <th style="width: 7%; text-align: center;">No.Invoice</th>
        <th>Customer</th>
        <th style="width: 7%; text-align: center;">Total</th>
        <th style="width: 5%; text-align:right">Diskon</th>
        <th style="width: 5%; text-align:right">Ppn</th>
        <th style="width: 7%; text-align:right">Ongkir</th>
        <th style="width: 7%; text-align:right">Total Net</th>
        <th style="width: 7%; text-align:right">Penerimaan</th>
        <th style="width: 7%; text-align:right">Outstanding</th>
        <th style="width: 5%; text-align:center">Cara Bayar</th>
        <th style="width: 5%; text-align:center">Via</th>
    </tr>
    </thead>
    <tbody>
    @php 
    $no_urut=1;
    $total=0; 
    $total_bayar = 0;
    $total_outs = 0;
    $ket_via = ""; 
    @endphp
    @foreach($list_data as $list)
    @php 
    if($list->bayar_via==1)
    {
        $ket_via = $list->get_via->penerimaan;
    } 
    if($list->bayar_via==2)
    {
        $total_terbayar_invoice = $list->get_piut_terbayar($list->id);
        $outs_invoice = $list->total_invoice_net - $total_terbayar_invoice;
    } else {
        $total_terbayar_invoice = $list->total_invoice_net;
        $outs_invoice = 0;
    }
    @endphp
    @if($check_view_detail=='true')
    <tr style="background-color: #e0dfde; color:black">
    @else
    <tr>
    @endif
        <td style='text-align: center; height: 25px;'>{{ $no_urut }}</td>
        <td style='text-align: center;'>{{ date_format(date_create($list->tgl_invoice), 'd-m-Y') }}</td>
        <td style='text-align: center;'>{{ $list->no_invoice }}</td>
        <td>{{ $list->get_customer->nama_customer }}</td>
        <td style='text-align: right;'>{{ number_format($list->total_invoice, 0) }}</td>
        <td style='text-align: right;'>{{ number_format($list->diskon_rupiah, 0) }}</td>
        <td style='text-align: right;'>{{ $list->ppn_rupiah }}</td>
        <td style='text-align: right;'>{{ number_format($list->ongkir, 0) }}</td>
        <td style='text-align: right;'><b>{{ number_format($list->total_invoice_net, 0) }}</b></td>
        <td style='text-align: right;'><b>{{ number_format($total_terbayar_invoice, 0) }}</b></td>
        <td style='text-align: right;'><b>{{ number_format($outs_invoice, 0) }}</b></td>
        <td style='text-align: center;'>{{ ($list->bayar_via==1) ? 'Tunai' : 'Kredit' }}</td>
        <td style='text-align: center;'>{{ $ket_via }}</td>
    </tr>
    @if($check_view_detail=='true')
    <tr>
        <td colspan="13">
        <table class="table-bordered table-vcenter" style="font-size: 8pt; width: 100%; font-family: Arial, Helvetica, sans-serif;">
            <tr>
                <th class="text-center" style="width: 2%;">#</th>
                <th class="text-center" style="width: 10%;">Kode</th>
                <th>Nama</th>
                <th class="text-center" style="width: 10%;">Kemasan</th>
                <th class="text-center" style="width: 10%;">Satuan</th>
                <th class="text-center" style="width: 5%">Qty</th>
                <th class="text-right" style="width: 15%">Harga Satuan</th>
                <th class="text-right" style="width: 15%;" >Sub Total</th>
            </tr>
            <tbody>
            @php $nom=1 @endphp
            @foreach($list->get_detail as $det)
                <tr>
                <td>{{ $nom }}</td>
                <td>{{ $det->get_produk->kode }}</td>
                <td>{{ $det->get_produk->nama_produk }}</td>
                <td style='text-align: center'>{{ $det->get_produk->kemasan }}</td>
                <td style='text-align: center'>{{ $det->get_produk->get_unit->unit }}</td>
                <td style='text-align: center'>{{ number_format($det->qty, 0) }}</td>
                <td style='text-align: right'>{{ number_format($det->harga, 0) }}</td>
                <td style='text-align: right'>{{ number_format($det->sub_total, 0) }}</td>
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
    $total+=$list->total_invoice_net; 
    $total_bayar+=$total_terbayar_invoice;
    $total_outs+=$outs_invoice;
    @endphp
    @endforeach
    <tr style="background-color: #808080; color:azure">
        <td colspan="8" class="text-right"><b>TOTAL</b></td>
        <td style='text-align: right; height:30px'><b>{{ number_format($total, 0) }}</b></td>
        <td style='text-align: right; height:30px'><b>{{ number_format($total_bayar, 0) }}</b></td>
        <td style='text-align: right; height:30px'><b>{{ number_format($total_outs, 0) }}</b></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>
</main>
<footer><div class="dropdown-divider"></div><div class="text-center"><span class='badge' style='font-size: 8pt;'>Alamat : Jl. Sorumba No. 79, Wowawanggu, Kec. Kedia, Kota Kendari, Sulawesi Tenggara 93117<br>Telp. +62 401 3092867 Email : usahatanibersama21@gmail.com</span></div></footer>
</body>
</html>
