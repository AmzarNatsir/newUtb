<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>UTB PT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>APLIKASI UTB</h2>
            </div>
            <div class="card-body">
            Menyatakan bahwa :
            <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">Nomor</td>
            </tr>
            </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h2>Color QR Code</h2>
            </div>
            <div class="card-body">
                {!! QrCode::size(300)->format('png')->merge('/public/assets/AdminLTE/dist/img/utb_logo.png')->backgroundColor(255,90,0)->generate('RemoteStack') !!}
            </div>
        </div>
    </div>
</body>
</html>