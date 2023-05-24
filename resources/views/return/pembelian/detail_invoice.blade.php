<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
                <th rowspan="2" style="width: 16%; vertical-align: middle;">Nama Produk</th>
                <th colspan="3" class="text-center">Satuan</th>
                <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total (Rp.)</th>
                <th colspan="2" class="text-center">Potongan</th>
                <th rowspan="2" class="text-right" style="width: 12%;vertical-align: middle;">Sub Total Net (Rp.)</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 10%">Satuan</th>
                <th class="text-center" style="width: 12%">Qty</th>
                <th class="text-center" style="width: 10%">Harga Satuan</th>
                <th class="text-center" style="width: 6%">%</th>
                <th class="text-center" style="width: 9%">Nilai</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dtHead->get_detail as $list)
        <tr>
            <td><div class="icheck-primary"><input type="checkbox" value="" name="checkItem[]" id="{{ $list->id }}"><label for="{{ $list->id }}"></label></div></td>
            <td>{{ $list->get_produk->nama_produk }}</td>
            <td>{{ $list->get_produk->kemasan }} {{ $list->get_produk->get_unit->unit }}</td>
            <td align="center"><input type="text" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="{{ $list->qty }}" style="text-align:center" onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)" readonly></td>
            <td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="{{ $list->harga }}" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)" readonly></td>
            <td class="text-right"><input type="text" name="item_sub_total[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka" readonly></td>
            <td class="text-right"><input type="text" name="item_diskon[]" value="{{ (empty($list->diskitem_persen)) ? 0 : $list->diskitem_persen }}" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)" readonly></td>
            <td class="text-right"><input type="text" name="item_diskonrp[]" value="{{ (empty($list->diskitem_rupiah)) ? 0 : $list->diskitem_rupiah }}" class="form-control form-control-sm text-right angka" onkeyup="hitDiskonNilai(this)" onblur="changeToNull()" readonly></td>
            <td class="text-right"><input type="text" name="item_sub_total_net[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka" readonly></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('.angka').number( true, 0 );
    });
</script>