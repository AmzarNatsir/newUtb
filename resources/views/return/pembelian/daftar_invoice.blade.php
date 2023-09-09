<div class="card card-widget widget-user-2">
    <div class="card-footer p-0">
        <ul class="nav flex-column">
            @foreach($list_invoice as $list)
            @php
            $qty_return = $list->get_return_beli_sum_qty($list->id);
            $total_return = $list->get_return_beli_sum_total($list->id);
            $selisih = $list->get_detail->sum('qty') - $list->get_detail->sum('qty_return');
            @endphp
            @if($selisih > 0)
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onClick="viewInvoice(this)" id="{{ $list->id }}">
                {{ $list->nomor_receive }} | {{ date_format(date_create($list->tanggal_receive), 'd-m-Y') }}
                <table style="width: 100%">
                    <tr>
                        <td style="width: 50%">Receive</td>
                        <td>Return</td>
                    </tr>
                    <tr>
                        <td><span class="float-left badge bg-success">Rp. {{ number_format($list->total_receive_net, 0) }}/ Qty : {{ number_format($list->get_detail->sum('qty'), 0) }}</span></td>
                        <td><span class="float-left badge bg-danger">Rp. {{ number_format($total_return, 0) }}/ Qty : {{ number_format($qty_return, 0) }}</span></td>
                    </tr>
                </table>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
