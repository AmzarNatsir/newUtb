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
  <link rel="stylesheet" href="{{asset('assets/AdminLTE/dist/css/adminlte.min.css')}}">
  <style>
    @page { margin: 100px 40px; }
    header { position: fixed; top: -80px; left: 0px; right: 0px; height: 50px; }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
    p { page-break-after: always; }
    p:last-child { page-break-after: never; }
  </style>
</head>
<header>
<table style="width: 100%;">
<tr>
    <td style="text-align: right;"><img src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB Logo" class="brand-image elevation-3" style="opacity: .8; width: 150px;  height: auto;"></td>
</tr>
</table>
</header>
<footer><div class="dropdown-divider"></div><div class="text-right"><span class='badge bg-info' style='font-size: 8pt;'>&copy;{{ date("d/m/Y H:s") }}</span></div></footer>
<main style="margin-top: -30px;">
<table style="width: 100%;">
<tr>
    <td style="text-align: left;">
    <div class="callout callout-danger">
        <h5>PURCHASE ORDER</h5>
        <p <span class='badge bg-info' style='font-size: 9pt;'>Periode : {{ $resHead->tanggal_po }}</p>
    </div>
    </td>
</tr>
</table>
</main>
</body>
</html>
