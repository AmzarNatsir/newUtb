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
        <p>Home</p>
    </a>
</li>
<li class="nav-item menu-open">
    <a href="{{ route('dashboard') }}" class="nav-link"><i class="nav-icon fas fa-chart-pie"></i><p>Dashboard</p></a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Summary<i class="right fas fa-angle-left"></i></p></a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Best Seliing</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Pelaporan<i class="right fas fa-angle-left"></i></p></a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('laporanPembelian') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembelian</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporanPenjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laporanStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Stok</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Data Master<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('satuan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Satuan</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('listMerk') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Merek</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('supplier') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Supplier</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>Customer<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('customer') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Customer</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Submission Approval</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Switch Level Customer</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Manajemen Stok<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('stok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Stok Baru</p></a>
            <a href="{{ route('daftarStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Daftar Stok</p></a>
            <a href="{{ route('kartuStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Kartu Stok</p></a>
        </li>
    </ul>
</li>
<li class="nav-header">TRANSAKSI</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Transaksi<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('purchaseOrder') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Purchase Order</p></a>
            <a href="{{ route('receiving') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Receiving</p></a>
            <a href="{{ route('penjualan') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penjualan</p></a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('pemberianSampel') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pemberian Sample</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Keuangan<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pembayaranHutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Hutang</p></a>
            <a href="{{ route('penerimaanPiutang') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Penerimaan Piutang</p></a>
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Pembayaran Lainnya</p></a>
        </li>
    </ul>
</li>
<li class="nav-header">TOOLS</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th-large"></i>
        <p>Manajement User<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Group</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Permission Group</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Users</p></a>
        </li>
    </ul>
</li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>