<div class="modal-header">
    <h4 class="modal-title">Approve Transaksi Tingkatan Pertama</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> Item Produk</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" style="overflow-y: auto; max-height: 100vh">
                            <div class="table-responsive">
                                <table class="table table-bordered table-vcenter" id="list_item" style="font-size: 13px; width: 100%;">
                                    <tr>
                                        <th rowspan="2" class="text-center" style="width: 2%; vertical-align: middle;">#</th>
                                        <th rowspan="2" style="width: 16%; vertical-align: middle;">Nama Produk</th>
                                        <th colspan="3" class="text-center">Satuan</th>
                                        <th rowspan="2" class="text-right" style="width: 12%; vertical-align: middle;" >Sub Total (Rp.)</th>
                                        <th colspan="2" class="text-center">Potongan</th>
                                        <th rowspan="2" class="text-right" style="width: 10%;vertical-align: middle;">Sub Total Net (Rp.)</th>
                                        <th rowspan="2" colspan="2" class="text-center" style="width: 10%;vertical-align: middle;">Stok Akhir</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width: 10%">Satuan</th>
                                        <th class="text-center" style="width: 8%">Qty</th>
                                        <th class="text-center" style="width: 10%">Harga Satuan</th>
                                        <th class="text-center" style="width: 5%">%</th>
                                        <th class="text-center" style="width: 9%">Nilai</th>
                                    </tr>
                                    <tbody>
                                        @php
                                        $nom=1;
                                        $lanjut=0;
                                        $tolak=0;
                                        @endphp
                                        @foreach($head->get_detail as $list )
                                        <tr>
                                            <td class="text-center">{{ $nom }}</td>
                                            <td>{{ $list->get_produk->nama_produk }} ({{ $list->get_sub_produk->nama_produk }})</td>
                                            <td class="text-center">{{ $list->get_produk->kemasan }} {{ $list->get_produk->get_unit->unit }}</td>
                                            <td class="text-center"><b>{{ $list->qty }}</b></td>
                                            <td class="text-right">{{ number_format($list->harga, 0) }}</td>
                                            <td class="text-right">{{ number_format($list->sub_total, 0) }}</td>
                                            <td class="text-right">{{ $list->diskitem_persen }}</td>
                                            <td class="text-right">{{ number_format($list->diskitem_rupiah, 0) }}</td>
                                            <td class="text-right">{{ number_format($list->sub_total, 0) }}</td>
                                            <td class="text-center"><b>{{ $list->get_produk->stok_akhir }}</b></td>
                                            <td class="text-center">
                                                @if($list->get_produk->stok_akhir >= $list->qty)
                                                <button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                                @php $lanjut++; @endphp
                                                @else
                                                <button type="button" class="btn btn-danger btn-sm"> <i class="fa fa-times"></i></button>
                                                @php $tolak++; @endphp
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                        $nom++
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
    <form action="{{ route('persetujuanPenjualanStore') }}" method="post" onsubmit="return konfirm()">
    {{csrf_field()}}
    <input type="hidden" name="id_trans" id="id_trans" value="{{ $head->id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inp_nomor">Nomor Invoice</label>
                                <input type="text" class="form-control" value="{{ $head->no_invoice }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inp_kemasan">Tanggal Transaksi</label>
                                <div class="input-group date" id="inp_tgl_trans">
                                    <input type="text" class="form-control datetimepicker-input dtpicker" id="inp_tgl_trans" name="inp_tgl_trans" value="{{ (empty($head->tgl_transaksi)) ? '' : date_format(date_create($head->tgl_transaksi), 'd-m-Y') }}" required />
                                    <div class="input-group-append" >
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sel_supplier">Customer</label>
                        <input type="text" class="form-control" value="{{ $head->get_customer->nama_customer }}" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inp_carabayar">Cara Pembayaran</label>
                                <input type="text" class="form-control" id="inp_carabayar" value="{{ ($head->bayar_via==1) ? 'Tunai' : 'Kredit' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inp_jtp">Jatuh Tempo</label>
                                <input type="text" class="form-control" id="inp_jtp" value="{{ (empty($head->tgl_jatuh_tempo)) ? '' : date_format(date_create($head->tgl_jatuh_tempo), 'd-m-Y') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inp_keterangan">Keterangan</label>
                        <textarea class="form-control" readonly>{{ $head->keterangan }}</textarea>
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
                            <input type="text" class="form-control angka" id="inputTotal" name="inputTotal" value="{{ $head->total_invoice }}" style="text-align: right; background-color: black; color: white;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTotal_DiskPersen" class="col-sm-6 col-form-label text-right">Diskon (%)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control angka" id="inputTotal_DiskPersen" name="inputTotal_DiskPersen" value="{{ $head->diskon_persen }}" style="text-align: right;" readonly>
                        </div>
                        <label for="inputTotal_DiskRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control angka" id="inputTotal_DiskRupiah" name="inputTotal_DiskRupiah" value="{{ $head->diskon_rupiah }}" style="text-align: right;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTotal_PpnPersen" class="col-sm-6 col-form-label text-right">Ppn (%)</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control angka" id="inputTotal_PpnPersen" name="inputTotal_PpnPersen" value="{{ $head->ppn_persen }}" style="text-align: right;" readonly>
                        </div>
                        <label for="inputTotal_PpnRupiah" class="col-sm-1 col-form-label text-right">Rp.</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control angka" id="inputTotal_PpnRupiah" name="inputTotal_PpnRupiah" value="{{ $head->ppn_rupiah }}" style="text-align: right;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTotalNet" class="col-sm-6 col-form-label text-right">Total Net</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control angka" id="inputTotalNet" name="inputTotalNet" value="{{ $head->total_invoice_net }}" style="text-align: right; background-color: black; color: white;" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputOngkir" class="col-sm-6 col-form-label text-right">Ongkos Kirim</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control angka" id="inputOngkir" name="inputOngkir" value="{{ $head->ongkir }}" style="text-align: right; background-color: black; color: white;" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputTotal" class="col-sm-4 col-form-label">Pilihan Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="selApproval" id="selApproval">
                                @if($tolak>0)
                                <option value="2" selected>Ditolak</option>
                                @else
                                <option value="1">Setuju</option>
                                <option value="2">Ditolak</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inp_catatan_persetujuan">Catatan Persetujuan</label>
                        @if($tolak>0)
                        @php 
                        $enabled_cat = "readonly";
                        $cat = 'Invoice Penjualan Ditolak. Stok Tidak Mencukupi. Klik Tombol Approve untuk membatalkan invoice'
                        @endphp
                        @else
                        @php $enabled_cat = "";
                        $cat = '';
                        @endphp
                        @endif
                        <textarea class="form-control" name="inp_catatan_persetujuan" id="inp_catatan_persetujuan" {{ $enabled_cat }}>{{ $cat }}</textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-outline-success" id="tbl_approve">Approve</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
</div>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script>
    $(function(){
        $('.dtpicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
        });
    });
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
