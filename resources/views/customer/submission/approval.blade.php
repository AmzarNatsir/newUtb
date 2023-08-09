<div class="modal-header">
    <h4 class="modal-title">Profil Pengajuan</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
</div>
<form action="{{ route('productSubUpdate', $profil->id) }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
{{ method_field('PUT') }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-user-alt mr-1"></i> Profil Calon Customer</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <strong><i class="fas fa-user mr-1"></i> Nama</strong><p class="text-muted">{{ $profil->nama_customer }}</p>
                  <hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                  <p class="text-muted">{{ $profil->alamat }} / {{ $profil->kota }}</p>
                  <hr>
                  <strong><i class="fas fa-phone-alt mr-1"></i> No.Telepon</strong>
                  <p class="text-muted">
                    {{ $profil->no_telepon }}
                  </p>
                  <hr>
                  <strong><i class="far fa-email-alt mr-1"></i> Email</strong>
                  <p class="text-muted">{{ $profil->get_email->email }}</p>
                  <hr>
                  <strong><i class="far fa-email-alt mr-1"></i> Level Customer Yang Diajukan</strong>
                  <p class="text-muted">
                  @if($profil->level==1)
                    <span class='badge bg-primary' style="font-size: 13pt;">Customer</span>
                    @elseif($profil->level==2)
                    <span class='badge bg-success' style="font-size: 13pt;">Agent</span>
                    @else
                    <span class='badge bg-danger' style="font-size: 13pt;">Reseller</span>
                    @endif
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-image mr-1"></i> Dokumen</h3>
                </div>
                <div class="card-body">
                    <div class="timeline-body">
                        <img src="https://placehold.it/150x100" alt="...">
                        <img src="https://placehold.it/150x100" alt="...">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt mr-1"></i> Map Lokasi</h3>
                </div>
                <div class="card-body">
                    <img width="750" height="400" class="img-fluid"
src="https://maps.geoapify.com/v1/staticmap?style=osm-carto&width=600&height=400&center=lonlat:{{ $profil->lng }},{{ $profil->lat }}&zoom=17.6&apiKey=567c96b8d76c419e8f53c7ec60447c53"
alt="{{ $profil->alamat }} / {{ $profil->kota }}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-outline-success" disabled>Simpan</button>
    </div>
</form>
<script type="text/javascript" src="{{ asset('assets/js/initAll.js') }}"></script>
<script>
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
