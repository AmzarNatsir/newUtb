<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="{{ url('home') }}" class="brand-link">
    <img src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8; width: 50px;  height: 50px;">
    <span class="brand-text font-weight-light"> PT UTB</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        @if(isset(auth()->user()->photo))
        <img src="{{ asset('images/pengguna/'.auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
        @else
        <img src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" class="img-circle elevation-2" alt="User Image">
        @endif
    </div>
    <div class="info">
        <a href="{{ url('home') }}" class="d-block">{{ (isset(auth()->user()->name)) ? auth()->user()->name : "Development" }}</a>
    </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
        <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
        </button>
        </div>
    </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home </p>
    </a>
</li>
@php
$head_pelaporan = "";
$head_master = "";
$head_customer = "";
$head_manaj_stok = "";
$head_data_transaksi = "";
$head_transaksi = "";
$head_keuangan = "";
$head_persetujuan = "";
$head_manaj_user = "";
@endphp
@if(auth()->user()->can('laporan_stok') || auth()->user()->can('laporan_pemberian_sampel') || auth()->user()->can('laporan_pembelian') || auth()->user()->can('laporan_penjualan') || auth()->user()->can('laporan_return_pembelian') || auth()->user()->can('laporan_return_penjualan') || auth()->user()->can('laporan_bayar_hutang') || auth()->user()->can('laporan_terima_piutang') || auth()->user()->can('laporan_hutang_kontainer'))
@php $head_pelaporan = "y" @endphp
@endif
@if(auth()->user()->can('master_satuan') || auth()->user()->can('master_merek') || auth()->user()->can('master_supplier') || auth()->user()->can('master_kontainer') || auth()->user()->can('master_via'))
@php $head_master = "y" @endphp
@endif
@if(auth()->user()->can('daftar_customer') || auth()->user()->can('customer_submission') || auth()->user()->can('customer_switch_level'))
@php $head_customer = "y" @endphp
@endif

@if(auth()->user()->can('manajemen_stok_baru') || auth()->user()->can('manajemen_stok_daftar') || auth()->user()->can('manajemen_stok_kartu'))
@php $head_manaj_stok = "y" @endphp
@endif

@if(auth()->user()->can('daftar_transaksi_po') || auth()->user()->can('daftar_transaksi_receive') || auth()->user()->can('daftar_transaksi_penjualan'))
@php $head_data_transaksi = "y" @endphp
@endif

@if(auth()->user()->can('transaksi_sampel') || auth()->user()->can('transaksi_po') || auth()->user()->can('transaksi_receive') || auth()->user()->can('transaksi_penjualan') || auth()->user()->can('transaksi_return_beli') || auth()->user()->can('transaksi_return_jual'))
@php $head_transaksi = "y" @endphp
@endif

@if(auth()->user()->can('keuangan_bayar_hutang') || auth()->user()->can('keuangan_terima_piutang') || auth()->user()->can('keuangan_hutang_kontainer'))
@php $head_keuangan = "y" @endphp
@endif

@if(auth()->user()->can('persetujaun_penjualan'))
@php $head_persetujuan = "y" @endphp
@endif

@if(auth()->user()->can('manaj_users_roles_permission') || auth()->user()->can('manaj_users_user'))
@php $head_manaj_user = "y" @endphp
@endif

@can('dashboard')
<li class="nav-item menu-open">
    <a href="{{ route('dashboard') }}" class="nav-link"><i class="nav-icon fas fa-chart-pie"></i><p>Dashboard</p></a>
</li>
@endcan
@if($head_pelaporan=='y')
<li class="nav-item">
    <a href="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Pelaporan<i class="right fas fa-angle-left"></i></p></a>
    <ul class="nav nav-treeview">
        @can('laporan_stok')
        <li class="nav-item">
            <a href="{{ route('laporanStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Stok</p></a>
        </li>
        @endcan
        @can('laporan_pemberian_sampel')
        <li class="nav-item">
            <a href="{{ route('laporanPemerianSampel') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pemberian Sampel</p></a>
        </li>
        @endcan
        @can('laporan_pembelian')
        <li class="nav-item">
            <a href="{{ route('laporanPembelian') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembelian</p></a>
        </li>
        @endcan
        @can('laporan_penjualan')
        <li class="nav-item">
            <a href="{{ route('laporanPenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
        </li>
        @endcan
        @can('laporan_return_pembelian')
        <li class="nav-item">
            <a href="{{ route('laporanReturnPembelian') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Return Pembelian</p></a>
        </li>
        @endcan
        @can('laporan_return_penjualan')
        <li class="nav-item">
            <a href="{{ route('laporanReturnPenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Return Penjualan</p></a>
        </li>
        @endcan
        @can('laporan_bayar_hutang')
        <li class="nav-item">
            <a href="{{ route('laporanHutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Hutang</p></a>
        </li>
        @endcan
        @can('laporan_terima_piutang')
        <li class="nav-item">
            <a href="{{ route('laporanPiutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penerimaan Piutang</p></a>
        </li>
        @endcan
        @can('laporan_hutang_kontainer')
        <li class="nav-item">
            <a href="{{ route('laporanHutangKontainer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Hutang Kontainer</p></a>
        </li>
        @endcan
        @can('laporan_hpp')
        <li class="nav-item">
            <a href="{{ route('laporanHPP') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Harga Pokok Penjualan</p></a>
        </li>
        @endcan
    </ul>
</li>
@endif
@if($head_master=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Data Master<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        @can('master_satuan')
        <li class="nav-item">
            <a href="{{ route('satuan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Satuan</p></a>
        </li>
        @endcan
        @can('master_merek')
        <li class="nav-item">
            <a href="{{ route('listMerk') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Merek</p></a>
        </li>
        @endcan
        @can('master_supplier')
        <li class="nav-item">
            <a href="{{ route('supplier') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Supplier</p></a>
        </li>
        @endcan
        @can('master_kontainer')
        <li class="nav-item">
            <a href="{{ route('kontainer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Kontainer</p></a>
        </li>
        @endcan
        @can('master_via')
        <li class="nav-item">
            <a href="{{ route('via') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penerimaan Via</p></a>
        </li>
        @endcan
    </ul>
</li>
@endif
@if($head_customer=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Customer<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        @can('daftar_customer')
        <li class="nav-item">
            <a href="{{ route('customer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Customer</p></a>
        </li>
        @endcan
        @can('customer_submission')
        <li class="nav-item">
            <a href="{{ route('submissionCustomer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Submission Approval</p></a>
        </li>
        @endcan
        @can('customer_switch_level')
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Switch Level Customer</p></a>
        </li>
        @endcan
    </ul>
</li>
@endif
@if($head_manaj_stok=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Manajemen Stok<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @can('manajemen_stok_baru')
            <a href="{{ route('stok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Stok Baru</p></a>
            @endcan
            @can('manajemen_stok_daftar')
            <a href="{{ route('daftarStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Daftar Stok</p></a>
            @endcan
            @can('manajemen_stok_kartu')
            <a href="{{ route('kartuStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Kartu Stok</p></a>
            @endcan
        </li>
    </ul>
</li>
@endif
@if($head_data_transaksi=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Daftar Transaksi<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @can('daftar_transaksi_po')
            <a href="{{ route('invoicePO') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Purchase Order</p></a>
            @endcan
            @can('daftar_transaksi_receive')
            <a href="{{ route('invoiceReceiving') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Receiving</p></a>
            @endcan
            @can('daftar_transaksi_penjualan')
            <a href="{{ route('invoicePenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
            @endcan
            @can('daftar_transaksi_pemberian_sample')
            <a href="{{ route('invoicePemberianSample') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pemberian Sample</p></a>
            @endcan
        </li>
    </ul>
</li>
@endif
@if($head_transaksi=="y" || $head_keuangan=="y")
<li class="nav-header">TRANSAKSI</li>
@endif
@if($head_transaksi=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Transaksi<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @can('transaksi_sampel')
            <a href="{{ route('pemberianSampel') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pemberian Sample</p></a>
            @endcan
            @can('transaksi_po')
            <a href="{{ route('purchaseOrder') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Purchase Order</p></a>
            @endcan
            @can('transaksi_receive')
            <a href="{{ route('receiving') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Receiving</p></a>
            @endcan
            @can('transaksi_penjualan')
            <a href="{{ route('penjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
            @endcan
            @can('transaksi_return_beli')
            <a href="{{ route('returnPembelian') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Return Pembelian</p></a>
            @endcan
            @can('transaksi_return_jual')
            <a href="{{ route('returnPenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Return Penjualan</p></a>
            @endcan
        </li>
    </ul>
</li>
@endif
@if($head_keuangan=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Keuangan<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @can('keuangan_bayar_hutang')
            <a href="{{ route('pembayaranHutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Hutang</p></a>
            @endcan
            @can('keuangan_terima_piutang')
            <a href="{{ route('penerimaanPiutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penerimaan Piutang</p></a>
            @endcan
            @can('keuangan_hutang_kontainer')
            <a href="{{ route('pembayaranHutangKontainer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Hutang Kontainer</p></a>
            @endcan
            <!-- <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Lainnya</p></a> -->
        </li>
    </ul>
</li>
@endif
@if($head_persetujuan=="y" || $head_manaj_user=="y")
<li class="nav-header">TOOLS</li>
@endif
@if($head_persetujuan=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-thumbs-up"></i>
        <p>Persetujuan<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @can('persetujuan_pemberian_sampel')
            <a href="{{ route('persetujuanPemberianSample') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pemberian Sample</p></a>
            @endcan
            @can('persetujuan_po')
            <a href="{{ route('persetujuanPO') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Purchase Order</p></a>
            @endcan
            @can('persetujaun_penjualan')
            <a href="{{ route('persetujuanPenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
            @endcan
        </li>
    </ul>
</li>
@endif
@if($head_manaj_user=="y")
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>Manajement User<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        @can('manaj_users_roles_permission')
        <li class="nav-item">
            <a href="{{ route('roles_permission') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Roles Permission</p></a>
        </li>
        @endcan
        @can('manaj_users_user')
        <li class="nav-item">
            <a href="{{ route('users') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Users</p></a>
        </li>
        @endcan
    </ul>
</li>
@endif
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
