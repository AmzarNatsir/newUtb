<style>
    .ui-autocomplete {
    z-index: 215000000 !important;
    }
    input[type=number]
    {
    -moz-appearance: textfield;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title">Receiving</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('receiveStore') }}" method="post" onsubmit="return konfirm()">
{{csrf_field()}}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-list"></i> Item Produk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" style="overflow-y: auto; max-height: 100vh">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-vcenter" id="list_item" style="font-size: 13px">
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
                                        <tbody class="row_baru">
                                        @php
                                            $nom=1;
                                            $t_qty=0;
                                            @endphp
                                            @foreach($resHead->get_detail as $list)
                                            <tr class="rows_item" name="rows_item[]">
                                                <td><input type="hidden" name="id_row[]" value=""><button type="button" title="Hapus Baris" class="btn btn-danger btn-sm waves-effect waves-light" onclick="hapus_item(this)"><i class="fa fa-minus"></i></button></td>
                                                <td><input type="hidden" name="item_id[]" value="{{ $list->id }}"><input type="hidden" name="produk_id[]" value="{{ $list->produk_id }}"><label style="color: blue; font-size: 11pt">{{ $list->get_produk->nama_produk }}</label></td>
                                                <td style="text-align: center"><label style="color: blue; font-size: 11pt">{{ $list->get_produk->get_unit->unit }}</label></td>
                                                <td align="center"><input type="text" min="1" max="1000" id="item_qty[]" name="item_qty[]" class="form-control form-control-sm angka" value="{{ $list->qty }}" style="text-align:center" onkeyup="hitungSubTotal(this)" onblur="changeToNull(this)"></td>
                                                <td class="text-right"><input type="text" class="form-control form-control-sm angka" id="harga_satuan[]" name="harga_satuan[]" value="{{ $list->harga }}" style="text-align: right" onkeyup="hitSubTotal(this)" onblur="changeToNull(this)"></td>
                                                <td class="text-right"><input type="text" name="item_sub_total[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka"></td>
                                                <td class="text-right"><input type="text" name="item_diskon[]" value="{{ (empty($list->diskitem_persen)) ? 0 : $list->diskitem_persen }}" class="form-control form-control-sm text-right angka_dec" onkeyup="hitDiskon(this)" onblur="changeToNull(this)"></td>
                                                <td class="text-right"><input type="text" name="item_diskonrp[]" value="{{ (empty($list->diskitem_rupiah)) ? 0 : $list->diskitem_rupiah }}" class="form-control form-control-sm text-right angka" onkeyup="hitDiskonNilai(this)" onblur="changeToNull()"></td>
                                                <td class="text-right"><input type="text" name="item_sub_total_net[]" value="{{ $list->sub_total }}" class="form-control form-control-sm text-right angka" readonly></td>
                                            </tr>
                                            @php
                                            $nom++;
                                            $t_qty+=$list->qty;
                                            @endphp
                                            @endforeach
                                        </tbody>
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
                        <input type="hidden" name="inp_id_po" value="{{ $resHead->id }}">
                        <input type="hidden" name="sel_supplier" value="{{ $resHead->supplier_id }}">
                        <input type="hidden" name="inp_carabayar" value="{{ $resHead->cara_bayar }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_nomor">Nomor PO</label>
                                    <input type="text" class="form-control" value="{{ $resHead->nomor_po }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_kemasan">Tanggal PO</label>
                                    <input type="text" class="form-control" value="{{ date_format(date_create($resHead->tanggal_po), 'd-m-Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sel_supplier">Supplier</label>
                            
                            <input type="text" class="form-control" value="{{ $resHead->get_supplier->nama_supplier }}" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_no_invoice">Nomor Invoice</label>
                                    <input type="text" class="form-control" name="inp_no_invoice" id="inp_no_invoice" maxlength="50" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_tgl_invoice">Tanggal Invoice</label>
                                    <div class="input-group date" id="inp_tgl_invoice">
                                        <input type="text" class="form-control datetimepicker-input datepicker" id="inp_tgl_invoice" name="inp_tgl_invoice" required>
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_carabayar">Cara Pembayaran</label>
                                    <input type="text" class="form-control" value="{{ ($resHead->cara_bayar==1) ? 'Tunai' : 'Kredit' }}" readonly>
                                </div>
                            </div>
                            @if($resHead->cara_bayar==1) 
                            @php $ket_jtp = "disabled" @endphp
                            @else
                            @php $ket_jtp = "" @endphp
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_tgl_invoice">Jatuh Tempo</label>
                                    <div class="input-group date" id="inp_tgl_jatuh_tempo">
                                        <input type="text" class="form-control datetimepicker-input datepicker" id="inp_tgl_jatuh_tempo" name="inp_tgl_jatuh_tempo" {{ $ket_jtp }} />
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inp_keterangan">Keterangan</label>
                            <textarea class="form-control" readonly>{{ $resHead->keterangan }}</textarea>
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
                                <input type="hidden" name="total_qty" id="total_qty" value="{{ $t_qty }}">
                                <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="{{ $resHead->total_po }}" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_DiskPersen" class="col-sm-6 col-form-label text-right">Diskon (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalPersen(this)">
                            </div>
                            <label for="inputTotal_DiskRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitDiskonTotalNilai(this)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotal_PpnPersen" class="col-sm-6 col-form-label text-right">Ppn (%)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalPersen(this)">
                            </div>
                            <label for="inputTotal_PpnRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="0" style="text-align: right;" onblur="changeToNull(this)" onkeyup="hitPpnTotalNilai(this)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputTotalNet" class="col-sm-6 col-form-label text-right">Total Net</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="{{ $resHead->total_po_net }}" style="text-align: right; background-color: black; color: white;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sel_kontainer">Kontainer</label>
                            <select class="form-control select2bs4" name="sel_kontainer" id="sel_kontainer" style="width: 100%;" placeholder="Pilihan Kontainer" required>   
                                <option></optionn>
                                @foreach($listKontainer as $kontainer)

                                <option value="{{ $kontainer->id }}">{{ $kontainer->nama_kontainer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_nomor">Nomor Invoice Kontainer</label>
                                    <input type="text" class="form-control" name="inp_invoice_kontainer" id="inp_invoice_kontainer" maxlength="50" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inp_ongkir_kontainer">Ongkir Kontainer</label>
                                    <input type="text" class="form-control angka" id="inp_ongkir_kontainer" name="inp_ongkir_kontainer" value="0" style="text-align: right;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inpTglTiba">Tanggal Tiba</label>
                                    <div class="input-group date" id="inpTglTiba">
                                        <input type="text" class="form-control datetimepicker-input datepicker" id="inpTglTiba" name="inpTglTiba" required />
                                        <div class="input-group-append" >
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
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
<script>
$(function(){
    $('.angka').number( true, 0 );
    $('.datepicker').datepicker({  autoclose: true });
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        placeholder: "Select",
        allowClear: true
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
    if($(el).val()=="")
    {
        $(el).val("0");
    }
}

var hitSubTotal = function(el)
{
    hitungSubTotal(el);
}

var hitDiskon = function(el)
{
    var currentRow=$(el).closest("tr");
    var diskon = $(el).parent().parent().find('input[name="item_diskon[]"]').val();
    var sub_total = currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val();
    var nilai_diskon = (diskon/100)*sub_total;
    currentRow.find('td:eq(7) input[name="item_diskonrp[]"]').val(nilai_diskon);
    hitungSubTotal(el);
}

var hitDiskonNilai = function(el)
{
    var currentRow=$(el).closest("tr");
    var total = currentRow.find('td:eq(5) input[name="item_sub_total[]"]').val();
    var diskon_rupiah = $(el).parent().parent().find('input[name="item_diskonrp[]"]').val();
    var persen_disk_total = (diskon_rupiah*100)/total;
    currentRow.find('td:eq(6) input[name="item_diskon[]"]').val(Math.floor(persen_disk_total));
    hitungSubTotal(el)
}

var hitDiskonTotalPersen = function(el)
{
    var total = $("#inputTotal").val();
    var diskon_persen = $(el).val();
    var nilai_disk_total = (diskon_persen/100)*total;
    $("#inputTotal_DiskRupiah").val(nilai_disk_total);
    hitung_total_net()
}

var hitDiskonTotalNilai = function(el)
{
    var total = $("#inputTotal").val();
    var diskon_rupiah = $(el).val();
    var persen_disk_total = (diskon_rupiah*100)/total;
    $("#inputTotal_DiskPersen").val(persen_disk_total);
    hitung_total_net()
}

var hitPpnTotalPersen = function(el)
{
    var total = $("#inputTotal").val();
    var ppn_persen = $(el).val();
    var nilai_ppntotal = (ppn_persen/100)*total;
    $("#inputTotal_PpnRupiah").val(nilai_ppntotal);
    hitung_total_net()
}

var hitPpnTotalNilai = function(el)
{
    var total = $("#inputTotal").val();
    var ppn_rupiah = $(el).val();
    var persen_ppn_total = (ppn_rupiah*100)/total;
    $("#inputTotal_PpnPersen").val(persen_ppn_total);
    hitung_total_net()
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
    var total_qty=0;
    var sub_total_qty = 0;
    $.each($('input[name="item_sub_total_net[]"]'),function(key, value){
        sub_total = $(value).val() ?  $(value).val() : 0;
        total += parseFloat($(value).val());
    })
    $.each($('input[name="item_qty[]"]'),function(key, value){
        sub_total_qty = $(value).val() ?  $(value).val() : 0;
        total_qty += parseFloat($(value).val());
    })
    $("#inputTotal").val(total);
    $("#total_qty").val(total_qty);
    hitung_total_net();
} 

function hitung_total_net()
{
    var total = $("#inputTotal").val();
    var diskon_rupiah = $("#inputTotal_DiskRupiah").val();
    var ppn_rupiah = $("#inputTotal_PpnRupiah").val();
    var total_net = (total - diskon_rupiah) + parseInt(ppn_rupiah);
    $("#inputTotalNet").val(total_net);
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
<!-- <script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/receive/receiveAdd.js') }}"></script> -->