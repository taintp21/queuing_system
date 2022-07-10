@extends('layouts.app')
@section('web-title', 'Đăng ký')
@section('content')
    <div class="row align-items-center">
        <div class="col-md-6 h-100vh pt-5">
            <div class="text-center my-5">
                <img src="{{ asset('images/logo.png') }}" width="170px" height="136px" alt="logo">
            </div>
            <form method="POST" aaction="{{ route('register') }}" class="m-auto">
                @csrf
                <div class="mb-3 col-xl-5 col-md-7 col-sm-5 m-auto">
                    <label for="username">Tên đăng nhập *</label>
                    <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 col-xl-5 col-md-7 col-sm-5 m-auto">
                    <label for="email">Địa chỉ Email</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 col-xl-5 col-md-7 col-sm-5 m-auto">
                    <label for="password">Mật khẩu *</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 col-xl-5 col-md-7 col-sm-5 m-auto">
                    <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-sm btn-theme">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 bg-white h-100vh pt-5">
            <div class="image-background text-center position-relative">
                <img src="{{ asset('images/image1.png') }}" class="img-fluid">
                <div class="centered-right color-1">
                    <h4>Hệ thống</h4>
                    <h3 class="fw-bolder">QUẢN LÝ XẾP HÀNG</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
