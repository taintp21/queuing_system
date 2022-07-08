@extends('layouts.app')
@include('sweetalert::alert')
@section('web-title', 'Thêm thiết bị')
@section('page-title', 'Quản lý thiết bị')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('select2/select2.min.css') }}">
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-body p-4">
                <form id="addform" action="{{ route('devices.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5 class="fw-bold color-1">Thông tin thiết bị</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mb-3">
                                <label for="device_code">Mã thiết bị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="device_code" id="device_code" placeholder="Nhập mã thiết bị" autofocus value="{{old('device_code')}}">
                                <span id="device_code-error" class="text-danger fw-bold d-none"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="device_name">Tên thiết bị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="device_name" id="device_name" placeholder="Nhập tên thiết bị" value="{{old('device_name')}}">
                                <span id="device_name-error" class="text-danger fw-bold d-none"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="ip_address">Địa chỉ IP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ip_address" id="ip_address" placeholder="Nhập địa chỉ IP" value="{{old('ip_address')}}">
                                <span id="ip_address-error" class="text-danger fw-bold d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mb-3">
                                <label for="device_type">Loại thiết bị <span class="text-danger">*</span></label>
                                <select name="device_type" id="device_type" class="form-select">
                                    <option value="" hidden disabled selected>Chọn loại thiết bị</option>
                                    <option value="Kiosk">Kiosk</option>
                                    <option value="Display counter">Display counter</option>
                                </select>
                                <span id="device_type-error" class="text-danger fw-bold d-none"></span>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Nhập tài khoản" value="{{old('username')}}">
                                <span id="username-error" class="text-danger fw-bold d-none"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" value="{{old('password')}}">
                                <span id="password-error" class="text-danger fw-bold d-none"></span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Dịch vụ sử dụng <span class="text-danger">*</span></label>
                            <select name="description[]" class="form-select" multiple="multiple">
                                <option value="Khám tim mạch">Khám tim mạch</option>
                                <option value="Khám Sản - Phụ khoa">Khám Sản - Phụ khoa</option>
                                <option value="Khám răng hàm mặt">Khám răng hàm mặt</option>
                                <option value="Khám tai mũi họng">Khám tai mũi họng</option>
                                <option value="Khám hô hấp">Khám hô hấp</option>
                                <option value="Khám tổng quát">Khám tổng quát</option>
                            </select>
                            <span id="description-error" class="text-danger fw-bold"></span>
                        </div>
                        <p><span class="text-danger">*</span> Là trường thông tin bắt buộc</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 my-5">
        <div class="inline-block text-center">
            <button type="button" onclick="location.href='{{ route('devices.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
            <button type="button" class="addbtn btn btn-theme">Thêm thiết bị</button>
        </div>
    </div>
</div>
@stop
@section('custom_scripts')
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('select2/select2.min.js') }}"></script>
<script src="{{ asset('js/crud/devices.js') }}"></script>
<script>
    $(document).ready(function(){
        $('select[name="description[]"]').select2({
            tags: true,
            multiple: true,
            tokenSeparators: [',', ' '],
            width: '100%',
            placeholder: "Nhập dịch vụ sử dụng",
        });
        $('.select2-search__field').addClass('form-control');
    });
    $(document).on("keypress",function(event) {
        var keyCode = event.which || event.keyCode;
        if (keyCode == 13) {
            $(".addbtn").click();
            return false;
        }
    });
</script>
@stop
