@extends('layouts.app')
@include('sweetalert::alert')
@section('web-title', 'Quên mật khẩu')

@section('content')
    <div class="row align-items-center">
        <div class="col-md-6 h-100vh pt-5">
            <div class="text-center my-5">
                <img src="{{ asset('images/logo.png') }}" width="170px" height="136px" alt="logo">
            </div>
            <form method="POST" action="{{ route('password.update') }}" class="m-auto">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3 col-md-5 m-auto">
                    <h5 class="fw-bold text-center">Đặt lại mật khẩu mới</h5>
                    <input type="hidden" name="email" value="{{ request('email') }}">
                    <label for="password">Mật khẩu</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 col-md-5 m-auto">
                    <label for="password-confirm">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-theme">Xác nhận</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 bg-white h-100vh pt-5">
            <div class="image-background text-center position-relative">
                <img src="{{ asset('images/image1.png') }}" alt="background-image">
                <div class="centered-right color-1">
                    <h4>Hệ thống</h4>
                    <h3 class="fw-bolder">QUẢN LÝ XẾP HÀNG</h3>
                </div>
            </div>
        </div>
    </div>
@endsection
