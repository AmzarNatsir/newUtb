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
    <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon fas fa-chart-pie"></i><p>Dashboard</p></a>
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
    <a href="#" class="nav-link"><i class="nav-icon fas fa-copy"></i><p>Report<i class="right fas fa-angle-left"></i></p></a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Stock</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-plus-square"></i>
        <p>Common<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('listUnit') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Unit</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('product') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Product</p></a>
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
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>List Customer</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Submission Approval</p></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Switch Level Customer</p></a>
        </li>
    </ul>
</li>
<li class="nav-header">TRANSACTION</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Stock Keeper<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('purchaseOrder') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Purchase Order</p></a>
            <a href="{{ route('receiving') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Receiving</p></a>
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Sale</p></a>
            <a href="{{ route('daftarStok') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Manajement Stock</p></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>Finance<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Cash Receipts</p></a>
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Cash Disbursement</p></a>
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Debet/Hutang</p></a>
            <a href="{{ route('home') }}" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p>Credit/Piutang</p></a>
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