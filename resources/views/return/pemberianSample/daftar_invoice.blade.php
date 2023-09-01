<div class="card card-widget widget-user-2">
    <div class="card-footer p-0">
        <ul class="nav flex-column">
            @foreach($list_invoice as $list)
            <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link" onClick="viewInvoice(this)" id="{{ $list->id }}">
                {{ $list->no_invoice }} | {{ date_format(date_create($list->tgl_invoice), 'd-m-Y') }} <span class="float-right badge bg-danger" style="font-size: small">Items {{ number_format($list->get_detail->sum('qty'), 0) }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
