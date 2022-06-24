@extends('layouts.app')
@section('web-title', 'Đăng nhập')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6 h-100vh pt-5">
            <div class="text-center my-5">
                <img src="{{ asset('images/logo.png') }}" width="170px" height="136px" alt="logo">
            </div>
            <form method="POST" action="{{ route('login') }}" class="m-auto">
                @csrf
                <div class="mb-3 col-md-5 m-auto">
                    <label for="username">Tên đăng nhập *</label>
                    <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 col-md-5 m-auto">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 col-md-5 m-auto">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none color-2 fw-bold link" href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                    @endif
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-sm btn-theme">
                        Đăng nhập
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-6 bg-white h-100vh pt-5">
            <div class="image-background text-center position-relative">
                <img src="{{ asset('images/image1.png') }}" alt="">
                <div class="centered-right color-1">
                    <h4>Hệ thống</h4>
                    <h3 class="fw-bolder">QUẢN LÝ XẾP HÀNG</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
