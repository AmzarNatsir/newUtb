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
    <td style='text-align: center;'>
    @if(empty($list->approved))
    <button type="button" class="btn btn-outline-success btn-sm" id="tbl_approve" name="tbl_approve" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-thumbs-up"></i> Approve</button>
    @endif
    </td>
    <td style='text-align: center;'>{{ $nom }}</td>
    <td style='text-align: center;'>{{ $list->no_invoice }}</td>
    <td style='text-align: center;'>{{ date_format(date_create($list->tgl_invoice), 'd-m-Y') }}</td>
    <td>{{ $list->get_customer->nama_customer }}</td>
    <td style='text-align: right;'><b>{{ number_format($list->total_invoice_net, 0) }}</b></td>
    <td style='text-align: center;'><span class='badge {{ $alert_ket }}'>{{ $ket_bayar }}</span></td>
    <td>
    @if($list->approved==2)    
    <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Rejected</button>
    @endif
    </td>
    </tr>
<?php
$nom++;
$total+=$list->total_invoice_net;
}
?>
