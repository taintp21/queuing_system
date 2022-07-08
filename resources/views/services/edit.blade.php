@extends('layouts.app')
@section('web-title', 'Cập nhật')
@section('page-title', 'Quản lý dịch vụ')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
<style>
    textarea{
        line-height: 1.29rem !important;
    }
    .form-check-input, .form-check-label{
        margin-right: .5rem;
    }
    .form-check-input{
        margin-top: 0!important;
    }
</style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <form id="editform" action="{{ route('services.update', ['id'=>$service->id]) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5 class="fw-bold color-1">Thông tin dịch vụ</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mb-3">
                                    <label for="service_code">Mã dịch vụ: <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="service_code" name="service_code" placeholder="Nhập mã dịch vụ" autofocus value="{{ $service->service_code }}">
                                    <span id="service_code-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="service_name">Tên dịch vụ: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="service_name" name="service_name" placeholder="Nhập tên dịch vụ" value="{{ $service->service_name }}">
                                    <span id="service_name-error" class="text-danger fw-bold d-none"></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="col-md-12">
                                    <label for="description">Mô tả:</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Mô tả dịch vụ">{{ $service->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h5 class="fw-bold color-1">Quy tắc cấp số</h5>
                            </div>
                            <div class="col-md-12 mb-3 d-flex align-items-center">
                                <input type="checkbox" class="form-check-input" id="increase_number">
                                <label for="increase_number" class="form-check-label me-4">Tăng tự động từ:</label>
                                <input type="number" class="form-control" name="number_from" style="max-width: 80px;" min="1" max="9999" value="{{ $service->number_from }}" @if($service->number_from == null) disabled @endif>
                                <label class="mx-3">đến</label>
                                <input type="number" class="form-control" name="number_to" style="max-width: 80px;" min="1" max="9999" value="{{ $service->number_to }}" @if($service->number_to == null) disabled @endif>
                            </div>
                            <div class="col-md-12 mb-3 d-flex align-items-center align-self-center">
                                <input type="checkbox" class="form-check-input" id="prefix">
                                <label for="prefix" class="form-check-label me-5">Prefix:</label>
                                <input type="number" class="form-control ms-5" name="prefix" style="max-width: 80px;" min="1" max="9999" value="{{ $service->prefix }}" @if($service->prefix == null) disabled @endif>
                            </div>
                            <div class="col-md-12 mb-3 d-flex align-items-center align-self-center">
                                <input type="checkbox" class="form-check-input" id="surfix">
                                <label for="surfix" class="form-check-label me-5">Surfix:</label>
                                <input type="number" class="form-control ms-5" name="surfix" style="max-width: 80px;" min="1" max="9999" value="{{ $service->surfix }}" @if($service->surfix == null) disabled @endif>
                            </div>
                            <div class="col-md-12 mb-3 d-flex align-items-center align-self-center">
                                <input type="checkbox" class="form-check-input" id="reset" name="reset" @if($service->reset == 0) checked @endif>
                                <label for="reset" class="form-check-label me-5">Reset mỗi ngày</label>
                            </div>
                            <input type="hidden" name="status" value="{{ $service->status }}">
                            <p><span class="text-danger">*</span> Là trường thông tin bắt buộc</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-5">
            <div class="inline-block text-center">
                <button type="button" onclick="location.href='{{ route('services.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
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
<script src="{{ asset('js/crud/services.js') }}"></script>
@stop
