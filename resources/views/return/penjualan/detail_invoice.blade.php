<form action="{{ route('returnPenjualanStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
<input type="hidden" name="inpInvoiceId" id="inpInvoiceId" value="{{ $dtHead->id }}">
<div class="table-responsive mailbox-messages">
    <table class="table table-hover table-striped" style="font-size: 12px; width: 100%">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="width: 1%; vertical-align: middle;">#</th>
                <th rowspan="2" style="vertical-align: middle; width: 15%">Nama Produk</th>
                <th colspan="4" class="text-center">Invoice</th>
                <th colspan="2" class="text-center">Return</th>
            </tr>
            <tr>
                <th class="text-center" style="width: 5%">Satuan</th>
                <th class="text-center" style="width: 10%">Qty</th>
                <th class="text-center" style="width: 12%">Harga</th>
                <th class="text-right" style="width: 12%;">Sub Total</th>
                <th class="text-center" style="width: 10%">Qty</th>
                <th class="text-right" style="width: 12%;">Sub Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dtHead->get_detail as $list)
        @php
        $selisih_receive = $list->qty - $list->qty_return;
        $sub_total_receive = $selisih_receive * $list->harga;
        @endphp
        <tr>
            <td><div class="icheck-primary"><input type="hidden" name="id_detail[]" id="id_detail[]" value="{{ $list->id }}" ><input type="hidden" name="item_id[]" id="item_id[]" value="{{ $list->produk_id }}"><input type="checkbox" value="" name="checkItem[]" id="{{ $list->id }}" onclick="checkItem(this)"><label for="{{ $list->id }}"></label></div><input type="hidden" name="selectItem[]" id="selectItem[]" value="0"></td>
            <td>{{ $list->get_produk->nama_produk }} ({{ $list->get_sub_produk->nama_produk }})</td>
            <td class="text-center">{{ $list->get_produk->kemasan }} {{ $list->get_produk->get_unit->unit }}</td>
            <td align="center"><input type="text" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="{{ $selisih_receive }}" style="text-align:center" readonly></td>
            <td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="{{ $list->harga }}" style="text-align: right" readonly></td>
            <td class="text-right"><input type="text" name="item_sub_total[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka" readonly></td>
            <td><input type="text"  class="form-control form-control-sm angka" name="qty_return[]" id="qty_return[]" value="0" onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)" style="text-align:center" readonly></td>
            <td class="text-right"><input type="text" name="return_sub_total[]" id="return_sub_total" value="0" class="form-control form-control-sm text-right angka" readonly></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="dropdown-divider"></div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inpNoInvoice" class="col-sm-6 col-form-label">No. Invoice</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" name="inpNoInvoice" id="inpNoInvoice" value="{{ $dtHead->no_invoice }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpTglInvoice" class="col-sm-6 col-form-label">Tgl. Invoice</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" name="inpTglInvoice" id="inpTglInvoice" value="{{ date_format(date_create($dtHead->tgl_transaksi), 'd-m-Y') }}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inpCustomer">Customer</label>
                    <input type="text" class="form-control input-sm" name="inpCustomer" id="inpCustomer" value="{{ $dtHead->get_customer->nama_customer }}" readonly>
                </div>
                <div class="form-group row">
                    <label for="inpTglReturn" class="col-sm-6 col-form-label">Tgl. Return</label>
                    <div class="col-sm-6">
                        <div class="input-group date" id="inpTglReturn">
                            <input type="text" class="form-control datetimepicker-input datepicker" id="inpTglReturn" name="inpTglReturn" value="{{ date('d/m/Y') }}" required />
                            <div class="input-group-append" >
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inpKeterangan">Keterangan</label>
                    <textarea class="form-control input-sm" name="inpKeterangan" id="inpKeterangan" required></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-outline-primary btn-block btn-sm" id="tbl_submit">Simpan</button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputTotal" class="col-sm-6 col-form-label text-right">Total Qty Return</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputGrandTotal" class="col-sm-6 col-form-label text-right">Total Harga Return</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control angka" id="inputGrandTotal" name="inputGrandTotal" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</form>
<script>
    $(function(){
        $('.angka').number( true, 0 );
    });
    var checkItem = function(el)
    {
        var currentRow=$(el).closest("tr");
        if($(el).prop('checked')){
            currentRow.find('td:eq(6) input[name="qty_return[]"]').attr('readonly', false);
            currentRow.find('td:eq(0) input[name="selectItem[]"]').val("1");
        } else {
            currentRow.find('td:eq(6) input[name="qty_return[]"]').attr('readonly', true);
            currentRow.find('td:eq(0) input[name="selectItem[]"]').val("0");
            ResetSubTotal(el);
        }
    }
    var hitungSubTotal = function(el){
        var currentRow=$(el).closest("tr");
        var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
        var harga = currentRow.find('td:eq(4) input[name="harga_satuan[]"]').val();
        var return_val = currentRow.find('td:eq(6) input[name="qty_return[]"]').val();
        var sub_total = parseFloat(return_val) * parseFloat(harga);
        if( parseFloat(return_val) > parseFloat(jumlah)) {
            currentRow.find('td:eq(6) input[name="qty_return[]"]').val(0)
            currentRow.find('td:eq(7) input[name="return_sub_total[]"]').val(0);
            total();
        } else {
            currentRow.find('td:eq(7) input[name="return_sub_total[]"]').val(sub_total);
            total();
        }
    }
    var ResetSubTotal = function(el){
        var currentRow=$(el).closest("tr");
        currentRow.find('td:eq(6) input[name="qty_return[]"]').val(0);
        currentRow.find('td:eq(7) input[name="return_sub_total[]"]').val(0);
        total();
    }
    var changeToNull = function(el)
    {
        if($(el).val()=="")
        {
            $(el).val("0");
        }
    }
    var total = function(){

        var total_qty = 0;
        var sub_total_qty = 0;
        var total = 0;
        var sub_total = 0;
        $.each($('input[name="qty_return[]"]'),function(key, value){
            sub_total_qty = $(value).val() ?  $(value).val() : 0;
            total_qty += parseFloat($(value).val());
        });
        $.each($('input[name="return_sub_total[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })
        $("#inputTotal").val(total_qty);
        $("#inputGrandTotal").val(total);
    }
    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
