@extends('layouts.app')
@include('sweetalert::alert')
@section('page-title', 'Quản lý tài khoản')
@section('web-title', 'Cập nhật tài khoản')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <form id="editform" action="{{ route('system.users.update', ['id'=>$data->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5 class="fw-bold color-1">Thông tin tài khoản</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="name">Họ tên *</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập họ tên" value="{{ $data->name }}">
                                    <span id="name-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="phone">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ $data->phone }}">
                                    <span id="phone-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" value="{{ $data->email }}">
                                    <span class="email-error text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="roles">Vai trò</label>
                                    <select name="roles_id" id="roles_id" class="form-select">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}" @if($data->roles_id == $r->id) selected @endif>{{ $r->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tên đăng nhập" value="{{ $data->username }}">
                                    <span id="username-error" class="text-danger fw-bold d-none"></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" value="{{ $data->password }}">
                                    <span id="password-error" class="text-danger fw-bold d-none"></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="password_confirmation">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu" value="{{ $data->password }}">
                                    <span id="password_confirmation-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="status">Tình trạng</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="0" @if($data->status == 0) selected @endif>Hoạt động</option>
                                        <option value="1" @if($data->status == 1) selected @endif>Ngưng hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="avatar" value="{{ $data->avatar }}">
                            <p><span class="text-danger">*</span> Là trường thông tin bắt buộc</p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-5">
            <div class="inline-block text-center">
                <button type="button" onclick="location.href='{{ route('system.users.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
                <button type="button" class="editbtn btn btn-theme">Cập nhật</button>
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
            $(".editbtn").click();
            return false;
        }
    });
</script>
<script src="{{ asset('js/crud/users.js') }}"></script>
@stop
