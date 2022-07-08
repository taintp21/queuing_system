@extends('layouts.app')
@include('sweetalert::alert')
@section('page-title', 'Danh sách vai trò')
@section('web-title', 'Thêm vai trò')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <form id="addform" action="{{ route('system.roles.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h5 class="fw-bold color-1">Thông tin vai trò</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role_name">Tên vai trò <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Nhập tên vai trò" value="{{old('role_name')}}">
                                    <span id="role_name-error" class="text-danger fw-bold d-none"></span>
                                </div>
                                <div class="mb-3">
                                    <label for="description">Mô tả</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả" cols="30" rows="10">{{ old('description') }}</textarea>
                                </div>
                                <p><span class="text-danger">*</span> Là trường thông tin bắt buộc</p>
                            </div>
                            <div class="col-md-6">
                                <label>Phân quyền chức năng <span class="text-danger">*</span></label>
                                <div class="background-3 p-3">
                                    <div class="group-1 mb-4">
                                        <h5 class="color-1 fw-bold">Nhóm chức năng A</h5>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="all1">
                                            <label class="form-check-label" for="all1">Tất cả</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-1" name="role_delegation" value="tb">
                                            <label class="form-check-label" for="g1-1">Xem thiết bị</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-2" name="role_delegation" value="dv">
                                            <label class="form-check-label" for="g1-2">Xem dịch vụ</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-3" name="role_delegation" value="cs">
                                            <label class="form-check-label" for="g1-3">Xem cấp số</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-4" name="role_delegation" value="bc">
                                            <label class="form-check-label" for="g1-4">Xem báo cáo</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-5" name="role_delegation" value="vt">
                                            <label class="form-check-label" for="g1-5">Xem vai trò</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-6" name="role_delegation" value="tk">
                                            <label class="form-check-label" for="g1-6">Xem tài khoản</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g1-7" name="role_delegation" value="nk">
                                            <label class="form-check-label" for="g1-7">Xem nhật ký</label>
                                        </div>
                                    </div>
                                    <div class="group-2">
                                        <h5 class="color-1 fw-bold">Nhóm chức năng B</h5>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="all2">
                                            <label class="form-check-label" for="all2">Tất cả</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g2-1" name="role_delegation" value="tb_action">
                                            <label class="form-check-label" for="g2-1">Quản lý thiết bị</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g2-2" name="role_delegation" value="dv_action">
                                            <label class="form-check-label" for="g2-2">Quản lý dịch vụ</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g2-3" name="role_delegation" value="cs_action">
                                            <label class="form-check-label" for="g2-3">Quản lý cấp số</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g2-4" name="role_delegation" value="vt_action">
                                            <label class="form-check-label" for="g2-4">Quản lý vai trò</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="g2-5" name="role_delegation" value="tk_action">
                                            <label class="form-check-label" for="g2-5">Quản lý tài khoản</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 my-5">
            <div class="inline-block text-center">
                <button type="button" onclick="location.href='{{ route('system.roles.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
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
<script src="{{ asset('js/crud/roles.js') }}"></script>
@stop
