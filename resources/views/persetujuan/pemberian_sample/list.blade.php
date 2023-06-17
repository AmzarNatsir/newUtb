<?php
$nom=1;
$total=0;
$ket_bayar="";
foreach($list_data as $list)
{ ?>
    <tr>
    <td style='text-align: center;'>
    @if(auth()->user()->approver=="y")
        @if(auth()->user()->lvl_approver==1)
            @if(empty($list->approved) && empty($list->approved_2))
            <button type="button" class="btn btn-outline-success btn-sm" id="tbl_approve" name="tbl_approve" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-thumbs-up"></i> Approve</button>
            @elseif($list->approved==1 && empty($list->approved_2))
            <button type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-hourglass"></i> Menunggu Approval<br>Kedua</button>
            @elseif($list->approved==2 || $list->approved_2==2)
            <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Ditolak</button>
            @endif
        @endif
        @if(auth()->user()->lvl_approver==2)
            @if(empty($list->approved))
            <button type="button" class="btn btn-outline-info btn-sm"><i class="fa fa-hourglass"></i> Menunggu Approval<br>Pertama</button>
            @elseif($list->approved==2 || $list->approved_2==2)
            <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Ditolak</button>
            @else
            <button type="button" class="btn btn-outline-success btn-sm" id="tbl_approve_2" name="tbl_approve_2" data-toggle="modal" data-target="#modal-form" value="{{ $list->id }}"><i class="fa fa-thumbs-up"></i> Approve</button>
            @endif
        @endif
    @endif
    </td>
    <td style='text-align: center;'>{{ $nom }}</td>
    <td style='text-align: center;'>{{ date_format(date_create($list->tgl_transaksi), 'd-m-Y') }}</td>
    <td>{{ $list->get_customer->nama_customer }}</td>
    <td style='text-align: center;'><b>{{ number_format($list->get_detail->sum('qty'), 0) }}</b></td>
    <td style='text-align: center;'>{{ $list->keterangan }}</td>
    </tr>
<?php
$nom++;
$total+=$list->total_invoice_net;
}
?>
