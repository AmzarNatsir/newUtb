<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
<!-- Left navbar links -->
<ul class="navbar-nav">
    <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
    <a href="{{ url('home') }}" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
    <a href="#" class="nav-link">@yield('breadcrumb')</a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    @if(isset(auth()->user()->photo))
                    <img src="{{ asset('images/pengguna/'.auth()->user()->photo) }}" class="user-image img-circle elevation-2" alt="User Image">
                    @else
                    <img src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                    @endif
                    <span class="d-none d-md-inline">{{ (!empty(Auth::user()->name)) ? Auth::user()->name : "" }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        @if(isset(auth()->user()->photo))
                        <img src="{{ asset('images/pengguna/'.auth()->user()->photo) }}" class="img-circle elevation-2" alt="User Image">
                        @else
                        <img src="{{asset('assets/AdminLTE/dist/img/utb_logo.png')}}" class="img-circle elevation-2" alt="User Image">
                        @endif
                        <p>
                            {{ (!empty(Auth::user()->name)) ? Auth::user()->name : "" }}
                            <small>Member since {{ (!empty(Auth::user()->created_at)) ? Auth::user()->created_at->format('M. Y') : "" }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
</ul>
</nav>
<!-- /.navbar -->