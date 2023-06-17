<div class="modal-header">
    <h4 class="modal-title">Approve Transaksi Tingkatan Kedua</h4>
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
                                        <th rowspan="2" style="vertical-align: middle;">Nama Produk</th>
                                        <th colspan="3" class="text-center">Satuan</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center" style="width: 10%">Satuan</th>
                                        <th class="text-center" style="width: 8%">Qty</th>
                                    </tr>
                                    <tbody>
                                        @php
                                        $nom=1;
                                        $total=0;
                                        @endphp
                                        @foreach($head->get_detail as $list )
                                        <tr>
                                            <td class="text-center">{{ $nom }}</td>
                                            <td>{{ $list->get_produk->nama_produk }}</td>
                                            <td class="text-center">{{ $list->get_produk->kemasan }} {{ $list->get_produk->get_unit->unit }}</td>
                                            <td class="text-center"><b>{{ $list->qty }}</b></td>
                                        </tr>
                                        @php
                                        $nom++;
                                        $total+=$list->qty;
                                        @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="3" style="text-align: right;"><b>TOTAL</b></td>
                                            <td style="text-align: center;"><b>{{ $total }}</b></td>
                                        </tr>
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
    <form action="{{ route('persetujuanPemberianSampleStore_2') }}" method="post" onsubmit="return konfirm()">
    {{csrf_field()}}
    <input type="hidden" name="id_trans" id="id_trans" value="{{ $head->id }}">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
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
                    <div class="form-group">
                        <label for="inp_keterangan">Keterangan</label>
                        <textarea class="form-control" readonly>{{ $head->keterangan }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"> Keterangan Aprroval Tingkatan Pertama</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <td style="width: 30%;">Tanggal</td>
                            <td>: {{ date_format(date_create($head->approved_date), 'd-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status Approval</td>
                            <td>: @if($head->approved==1)
                                <button type="button" class="btn btn-outline-success btn-sm"><i class="fa fa-check"></i> Approved</button>
                                @endif
                                @if($head->approved==2)
                                <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times"></i> Reject</button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>: {{ $head->approved_note }}</td>
                        </tr>
                        <tr>
                            <td>Oleh</td>
                            <td>: {{ $head->get_approver_1->name }}</td>
                        </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputTotal" class="col-sm-4 col-form-label">Pilihan Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="selApproval" id="selApproval">
                                <option value="1">Setuju</option>
                                <option value="2">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inp_catatan_persetujuan">Catatan Persetujuan</label>
                        <textarea class="form-control" name="inp_catatan_persetujuan" id="inp_catatan_persetujuan"></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success" id="tbl_approve">Approve</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    </form>
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
