<?php
$nom=1;
$total=0;
$ket_bayar="";
foreach($list_data as $list)
{ 
    if($list->bayar_via==1){
        $ket_bayar = "Cash";
        $alert_ket = "bg-success";
    } else {
        $ket_bayar = "Credit";
        $alert_ket = "bg-danger";
    }
    ?>
    <tr>
    <td style='text-align: center;'>{{ $nom }}</td>
    <td style='text-align: center;'>{{ $list->no_invoice }}</td>
    <td style='text-align: center;'>{{ date_format(date_create($list->tgl_invoice), 'd-m-Y') }}</td>
    <td>{{ $list->get_customer->nama_customer }}</td>
    <td style='text-align: right;'><b>{{ number_format($list->total_invoice_net, 0) }}</b></td>
    <td style='text-align: center;'><span class='badge {{ $alert_ket }}'>{{ $ket_bayar }}</span></td>
    <td style='text-align: center;'>
        <div class="input-group-prepend">
            <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-toggle="dropdown">
            Action
            </button>
            <div class="dropdown-menu">
                <button type="button" class="dropdown-item" id="tbl_approve" name="tbl_approve" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-thumbs-up"></i> Approve</button>
            </div>
        </div>
    </td>
    </tr>
<?php
$nom++;
$total+=$list->total_invoice_net;
}
?>
