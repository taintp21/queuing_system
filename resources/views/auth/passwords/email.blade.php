@extends('layouts.app')
@section('web-title', 'Quên mật khẩu')

@section('content')
    <div class="row align-items-center">
        <div class="col-md-6 h-100vh pt-5">
            <div class="text-center my-5">
                <img src="{{ asset('images/logo.png') }}" width="170px" height="136px" alt="logo">
            </div>
            <form method="POST" action="{{ route('password.email') }}" class="m-auto">
                @csrf
                <div class="mb-4 text-center col-md-6 m-auto">
                    <h4 class="fw-bold">Đặt lại mật khẩu</h4>
                    <label for="email" class="fw-normal">Vui lòng nhập email để đặt lại mật khẩu của bạn *</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback text-left" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 inline-block text-center">
                    <button type="button" class="btn btn-outline-theme" onclick="window.location='{{ route('login') }}'">Huỷ</button>
                    <button type="submit" class="btn btn-theme">Tiếp tục</button>
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
@section('custom_scripts')
    @if (session('status'))
        <script>
            Swal.fire(
                'Hoàn tất!',
                'Đã gửi liên kết đặt lại mật khẩu đến email của bạn.',
                'success'
            );
        </script>
    @endif
@stop
