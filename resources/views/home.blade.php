@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('SELAMAT DATANG ') }}</div>

                <div class="card-body">
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="{{ $auth_type ?? 'login' }}-logo;">
                        <a href="#">

                            {{-- Logo Image --}}
                            @if (config('adminlte.auth_logo.enabled', false))
                                <img src="{{ asset(config('adminlte.auth_logo.img.path')) }}"
                                    alt="{{ config('adminlte.auth_logo.img.alt') }}"
                                    @if (config('adminlte.auth_logo.img.class', null))
                                        class="{{ config('adminlte.auth_logo.img.class') }}"
                                    @endif
                                    @if (config('adminlte.auth_logo.img.width', null))
                                        width="{{ config('adminlte.auth_logo.img.width') }}"
                                    @endif
                                    @if (config('adminlte.auth_logo.img.height', null))
                                        height="{{ config('adminlte.auth_logo.img.height') }}"
                                    @endif>
                            @else
                                <img src="{{ asset(config('adminlte.logo_img')) }}"
                                    alt="{{ config('adminlte.logo_img_alt') }}" class="img-fluid" height="400px">
                            @endif

                            <!-- {{-- Logo Label --}}
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!} -->

                        </a>
                    </div>
                    <div style="text-align: center; margin: 20px;">
                    {{ __('Anda berhasil login sebagai ') }} <strong>{{ auth()->user()->roles()->pluck('name')->first() }}
                    : {{ auth()->user()->name }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
