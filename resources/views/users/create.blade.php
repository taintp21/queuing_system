@extends('layouts.app')
@include('sweetalert::alert')
@section('page-title', 'Quản lý tài khoản')
@section('web-title', 'Thêm tài khoản')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <form id="addform" action="{{ route('system.users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5 class="fw-bold color-1">Thông tin tài khoản</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập họ tên" value="{{ old('name') }}">
                                    <span id="name-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                                    <span id="phone-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" value="{{ old('email') }}">
                                    <span id="email-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="roles">Vai trò</label>
                                    <select name="roles_id" id="roles_id" class="form-select">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="avatar" value="default-avatar.png">
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" value="{{ old('username') }}">
                                    <span id="username-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu">
                                    <span id="password-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="password_confirmation">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu">
                                    <span id="password_confirmation-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="status">Tình trạng</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="0">Hoạt động</option>
                                        <option value="1">Ngưng hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <p><span class="text-danger">*</span> Là trường thông tin bắt buộc</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-5">
            <div class="inline-block text-center">
                <button type="button" onclick="location.href='{{ route('system.users.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
                <button type="button" class="addbtn btn btn-theme">Thêm</button>
            </div>
        </div>
    </div>
@stop
@section('custom_scripts')
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).on("keypress",function(event) {
        var keyCode = event.which || event.keyCode;
        if (keyCode == 13) {
            $(".addbtn").click();
            return false;
        }
    });
</script>
<script src="{{ asset('js/crud/users.js') }}"></script>
@stop
