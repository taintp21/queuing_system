@extends('layouts.app')
@include('sweetalert::alert')
@section('page-title', 'Vai trò')
@section('web-title', 'Thêm vai trò')
@section('content')
    <form id="addform" action="{{ route('system.roles.store') }}" method="POST">
        @csrf
        <div class="content">
            <h4 class="mb-4 fw-bold color-1">Thông tin vai trò</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="role_name">Tên vai trò</label>
                        <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Nhập tên vai trò" value="{{old('role_name')}}">
                    </div>
                    <div class="mb-3">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả" cols="30" rows="10">{{ old('description') }}</textarea>
                    </div>
                    <p>* Là trường thông tin bắt buộc</p>
                </div>
                <div class="col-md-6">
                    <label>Phân quyền chức năng *</label>
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
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="g2-6" name="role_delegation" value="nk_action">
                                <label class="form-check-label" for="g2-6">Quản lý nhật ký người dùng</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <button type="reset" class="col-md-2 btn btn-outline-theme">Huỷ bỏ</button>
            <button type="submit" id="add" class="col-md-2 btn btn-theme">Thêm</button>
        </div>
    </form>
@stop
@section('custom_scripts')
    <script>
        $(document).ready(function(){
            $("#all1").on('click', function(){
                var checkedState = this.checked;
                $(".group-1 .form-check :checkbox").each(function(){
                    this.checked = checkedState;
                });
            });
            $("#all2").on('click', function(){
                var checkedState = this.checked;
                $(".group-2 .form-check :checkbox").each(function(){
                    this.checked = checkedState;
                });
            });

            $("#add").click(function(){
                var checkboxes = [];
                $('input[name="role_delegation"]').each(function(){
                    if($(this).is(":checked")){
                        checkboxes.push($(this).val());
                    }
                });
                checkboxes = checkboxes.toString();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr("action"),
                    method: $(this).attr("method"),
                    data: {
                        role_name : $('input[name="role_name"]').val(),
                        description : $('textarea[name="description"]').val(),
                        role_delegation : checkboxes
                    },
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
