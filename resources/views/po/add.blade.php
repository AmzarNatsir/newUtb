<style>
    .ui-autocomplete {
    z-index: 215000000 !important;
    }
    input[type=number]
    {
    -moz-appearance: textfield;
    }
    .spinner-div {
        position: absolute;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 2;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title">Tambah data PO</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('purchaseOrderStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
    <div class="modal-body">
        <div class="row">
            <div id="spinner-div" class="pt-5 justify-content-center spinner-div">
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-plus"></i> Item Produk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="input-group" id="seacrhItem">
                                    <input type="text" class="form-control form-control-sm" name="inputSearch" id="inputSearch" placeholder="Masukkan Nama Produk" autocomplete="off">
                                    <div class="input-group-append" >
                                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-sm-12" style="overflow-y: auto; max-height: 100vh">
                                <div class="table-responsive">
                                    <table class="table-bordered table-vcenter" id="list_item" style="font-size: 13px; width: 100%" cellpadding="10">
                                        <tr>
                                            <th rowspan="2" class="text-center" style="width: 3%; vertical-align: middle;">#</th>
                                            <th rowspan="2" style="vertical-align: middle;">Nama Produk</th>
                                            <th colspan="3" class="text-center">Satuan</th>
                                            <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total (Rp.)</th>
                                            <th colspan="2" class="text-center">Potongan</th>
                                            <th rowspan="2" class="text-right" style="width: 12%;vertical-align: middle;">Sub Total Net (Rp.)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 10%">Satuan</th>
                                            <th class="text-center" style="width: 10%">Qty</th>
                                            <th class="text-center" style="width: 10%">Harga Satuan</th>
                                            <th class="text-center" style="width: 5%">%</th>
                                            <th class="text-center" style="width: 9%">Nilai</th>
                                        </tr>
                                        <tbody class="row_baru"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_kemasan">Tanggal PO</label>
                                    <div class="input-group date" id="inp_tgl_po">
                                        <input type="text" class="form-control datetimepicker-input datepicker" id="inp_tgl_po" name="inp_tgl_po" value="{{ date('d/m/Y') }}" />
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_supplier">Supplier</label>
                            <select class="form-control select2bs4" name="sel_supplier" id="sel_supplier" style="width: 100%;" required>   
                                @foreach($allSupplier as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inp_carabayar">Cara Pembayaran</label>
                            <select class="form-control select2bs4" name="inp_carabayar" id="inp_carabayar" style="width: 100%;" required>
                                <option value="1">Tunai</option>
                                <option value="2">Kredit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inp_keterangan">Keterangan</label>
                            <textarea class="form-control" name="inp_keterangan" id="inp_keterangan"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputTotal" class="col-sm-6 col-form-label text-right">Total</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_DiskPersen" class="col-sm-6 col-form-label text-right">Diskon (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalPersen(this)" readonly>
                            </div>
                            <label for="inputTotal_DiskRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalNilai(this)" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_PpnPersen" class="col-sm-6 col-form-label text-right">Ppn (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalPersen(this)" readonly>
                            </div>
                            <label for="inputTotal_PpnRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalNilai(this)" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotalNet" class="col-sm-6 col-form-label text-right">Total Net</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="0" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success" id="tbl_submit">Simpan</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script>
    $(function(){
        $('#spinner-div').hide();
        $('.datepicker').datepicker({
            autoclose: true
        });
        var total_net = $("#inputTotalNet").val();
        if(total_net==0)
        {
            $("#tbl_submit").attr("disabled", true);
        }
        $("#inputSearch").autocomplete({
            source: function(request, response) {
                //Fetch data
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ url('searchItemPO') }}",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    beforeSend: function()
                    {
                        $('#spinner-div').show();
                    },
                    success: function( data ) {
                        response(data);
                    },
                    complete: function()
                    {
                        $('#spinner-div').hide();
                    }

                });
            },
            select: function(event, ui) {
                $("#inputSearch").val(ui.item.label);
                var content_item = '<tr class="rows_item" name="rows_item[]"><td><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>'+'<td><input type="hidden" name="item_id[]" value="'+ui.item.value+'"><label style="color: blue; font-size: 11pt">'+ui.item.label+'</label></td>'+'<td style="text-align: center"><label style="color: blue; font-size: 11pt">'+ui.item.kemasan+" "+ui.item.satuan+'</label></td>'+'<td align="center"><input type="text" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="1" style="text-align:center" onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>'+'<td class="text-right"><input type="hidden" class="form-control form-control-sm" id="tmp_harga_satuan[]" name="tmp_harga_satuan[]" value="'+ui.item.harga_beli+'"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="'+ui.item.harga_beli+'" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNullHarga(this)"></td>'+'<td class="text-right"><input type="text" name="item_sub_total[]" value="'+ui.item.harga_beli+'" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskon[]" value="0" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)" readonly></td>'+'<td class="text-right"><input type="text" name="item_diskonrp[]" value="0" class="form-control form-control-sm text-right angka" readonly></td>'+'<td class="text-right"><input type="text" name="item_sub_total_net[]" value="'+ui.item.harga_beli+'" class="form-control form-control-sm text-right angka" readonly></td>'+'</tr>';
                $(".row_baru").after(content_item);
                $('.angka').number( true, 0 );
                $("#inputSearch").val("");
                total();
                return false;
            }
        });
    });

    var hapus_item = function(el){
        $(el).parent().parent().slideUp(100,function(){
            $(this).remove();
            total();
        });
    }
    var changeToNull = function(el)
    {
        if($(el).val()=="" || $(el).val()=="0")
        {
            $(el).val("1");
        }
        hitungSubTotal(el);
    }

    var changeToNullHarga = function(el)
    {
        var currentRow=$(el).closest("tr");
        var tmp_harga = currentRow.find('td:eq(4) input[name="tmp_harga_satuan[]"]').val();
        if($(el).val()=="" || $(el).val()=="0")
        {
            $(el).val(tmp_harga);
        }
        hitungSubTotal(el);
    }

    var hitSubTotal = function(el)
    {
        hitungSubTotal(el);
    }
    
    var add_qty = function(el)
    {
        var input = $(el).parent().parent().find('input[name="item_qty[]"]'),
            min = input.attr("min"),
            max = input.attr("max");
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        // input.val(newVal);
        $(el).parent().parent().find('input[name="item_qty[]"]').val(newVal);
        hitungSubTotal(el);
    }

    var min_qty = function(el)
    {
        var input = $(el).parent().parent().find('input[name="item_qty[]"]'),
            min = input.attr("min"),
            max = input.attr("max");
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        //input.val(newVal);
        $(el).parent().parent().find('input[name="item_qty[]"]').val(newVal);
        hitungSubTotal(el);
    }

    var hitungSubTotal = function(el){
        var currentRow=$(el).closest("tr");
        var jumlah = $(el).parent().parent().find('input[name="item_qty[]"]').val();
        var harga = currentRow.find('td:eq(4) input[name="harga_satuan[]"]').val();
        var sub_total = parseFloat(jumlah) * parseFloat(harga);
        currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val(sub_total);
        var hasil_diskon = currentRow.find('td:eq(7) input[name="item_diskonrp[]"]').val();
        var sub_total_setelah_diskon = sub_total - hasil_diskon;
        currentRow.find('td:eq(8) input[name="item_sub_total_net[]"]').val(sub_total_setelah_diskon);
        total();
    }  

    var total = function(){
        
        var total = 0;
        var sub_total = 0;
        $.each($('input[name="item_sub_total_net[]"]'),function(key, value){
            sub_total = $(value).val() ?  $(value).val() : 0;
            total += parseFloat($(value).val());
        })
        $("#inputTotal").val(total);
        hitung_total_net();
    } 

    function hitung_total_net()
    {
        var total = $("#inputTotal").val();
        var diskon_rupiah = $("#inputTotal_DiskRupiah").val();
        var ppn_rupiah = $("#inputTotal_PpnRupiah").val();
        var total_net = (total - diskon_rupiah) + parseInt(ppn_rupiah);
        $("#inputTotalNet").val(total_net);
        if(total_net>0)
        {
            $("#tbl_submit").attr("disabled", false);
        } else {
            $("#tbl_submit").attr("disabled", true);
        }
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