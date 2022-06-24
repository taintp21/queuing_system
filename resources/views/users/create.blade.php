@extends('layouts.app')
@include('sweetalert::alert')
@section('page-title', 'Quản lý tài khoản')
@section('web-title', 'Thêm tài khoản')
@section('content')
    <form id="addform" action="{{ route('system.users.store') }}" method="POST">
        @csrf
        <div class="content">
            <div class="row">
                <h4 class="mb-4 fw-bold color-1">Thông tin tài khoản</h4>
                <div class="col-md-6 mb-3">
                    <label for="name">Họ tên *</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập họ tên" value="{{ old('name') }}">
                    <span id="name-error" class="text-danger fw-bold d-none"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="username">Tên đăng nhập *</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" value="{{ old('username') }}">
                    <span id="username-error" class="text-danger fw-bold d-none"></span>
                </div>
                <input type="hidden" name="avatar" value="default-avatar.png">
                <div class="col-md-6 mb-3">
                    <label for="phone">Số điện thoại *</label>
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                    <span id="phone-error" class="text-danger fw-bold d-none"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password">Mật khẩu *</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu">
                    <span id="password-error" class="text-danger fw-bold d-none"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email *</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" value="{{ old('email') }}">
                    <span class="email-error text-danger fw-bold d-none"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation">Nhập lại mật khẩu *</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu">
                    <span id="password_confirmation-error" class="text-danger fw-bold d-none"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="roles">Vai trò</label>
                    <select name="roles_id" id="roles_id" class="form-select">
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status">Tình trạng</label>
                    <select name="status" id="status" class="form-select">
                        <option value="0">Hoạt động</option>
                        <option value="1">Ngưng hoạt động</option>
                    </select>
                </div>
                <p>* Là trường thông tin bắt buộc</p>
            </div>
        </div>
        <div class="inline-block text-center">
            <button type="reset" class="btn btn-outline-theme">Huỷ bỏ</button>
            <button type="submit" id="add" class="btn btn-theme">Thêm</button>
        </div>
    </form>
@stop
@section('custom_scripts')
    <script src="{{ asset('js/crud/users.js') }}"></script>
@stop
