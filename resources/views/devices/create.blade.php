@extends('layouts.app')
@include('sweetalert::alert')
@section('web-title', 'Thêm thiết bị')
@section('content')
    <form id="addform">
        @csrf
        <div class="row content">
            <h4 class="mb-4 fw-bold color-1">Thông tin thiết bị</h4>
            <div class="col-md-6 mb-3">
                <label for="device_code">Mã thiết bị</label>
                <input type="text" class="form-control" name="device_code" id="device_code" placeholder="Nhập mã thiết bị" autofocus value="{{old('device_code')}}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="device_type">Loại thiết bị</label>
                <select name="device_type" id="device_type" class="form-select">
                    <option value="0" disabled selected>Chọn loại thiết bị</option>
                    <option value="1">Kiosk</option>
                    <option value="2">Display counter</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="device_name">Tên thiết bị</label>
                <input type="text" class="form-control" name="device_name" id="device_name" placeholder="Nhập tên thiết bị" value="{{old('device_name')}}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="username">Tên đăng nhập</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tài khoản" value="{{old('username')}}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="ip_address">Địa chỉ IP</label>
                <input type="text" class="form-control" name="ip_address" id="ip_address" placeholder="Nhập địa chỉ IP" value="{{old('ip_address')}}">
            </div>
            <div class="col-md-6 mb-3">
                <label for="password">Mật khẩu</label>
                <input type="text" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" value="{{old('password')}}">
            </div>
            <div class="col-md-12 mb-3">
                <label for="description">Dịch vụ sử dụng</label>
                <input type="text" class="form-control" name="description" id="description" placeholder="Nhập dịch vụ sử dụng" value="{{old('description')}}">
            </div>
            <p>* Là trường thông tin bắt buộc</p>
        </div>
    </form>
    <div class="row justify-content-center">
        <button type="reset" class="col-md-2 btn btn-outline-theme">Huỷ bỏ</button>
        <button type="button" id="add" class="col-md-2 btn btn-theme">Thêm thiết bị</button>
    </div>
@stop
@section('custom_scripts')
    <script>
        $(document).ready(function(){
            $("#add").click(function(){
                $.ajax({
                    type: "POST",
                    url: "{{ route('devices.store') }}",
                    data: $("#addform").serialize(),
                    success: function(response){
                        Swal.fire(
                            'Hoàn tất!',
                            'Thêm thành công!',
                            'success'
                        );
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
        });
    </script>
@stop
