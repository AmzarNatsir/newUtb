<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" name="csrf-token" content="{{ csrf_token() }}" />
<title>UTB - @yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
@include('layouts.stylesheet')
@include('layouts.javascript')
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" alt="UTB" height="50px" width="60px">
    </div>
    <!-- Navbar -->
    @include('layouts.navbar')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')
    <!-- end sidebar -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        @yield('content')
        <!-- end main -->
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    @include('layouts.footer')
</div>
