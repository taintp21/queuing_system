@extends('layouts.app')
@include('sweetalert::alert')
@section('web-title', 'Cấp số mới')
@section('page-title', 'Quản lý cấp số')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <style>
        .form-select{
            width: 25%;
        }
        @media screen and (max-width: 768px){
            .form-select{
                width: 50%;
            }
        }
        .inline-block.text-center button{
            margin: 0 10px;
        }
        .card-body{
            min-height: 700px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-12">
                            <h3 class="color-1 fw-bold">CẤP SỐ MỚI</h3>
                        </div>
                        <div class="col-12 my-4">
                            <form id="addform" action="{{ route('give_num.store') }}" method="POST">
                                @csrf
                                <label for="service">Dịch vụ khách hàng lựa chọn</label>
                                <select name="service" id="service" class="form-select m-auto my-3">
                                    <option value="" hidden disabled selected>Chọn dịch vụ</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                    @endforeach
                                </select>
                                <span id="service-error" class="text-danger fw-bold d-none"></span>
                                <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Thông tin khách hàng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <p id="error" class="text-danger fw-bold d-none"></p>
                                                <div class="mb-3">
                                                    <label for="name" class="col-form-label">Họ tên:</label>
                                                    <input type="text" class="form-control" id="name" name="name">
                                                    <span id="name-error" class="text-danger fw-bold d-none"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="col-form-label">Số điện thoại:</label>
                                                    <input type="number" class="form-control" id="phone" name="phone">
                                                    <span id="phone-error" class="text-danger fw-bold d-none"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="col-form-label">Địa chỉ email:</label>
                                                    <input type="text" class="form-control" id="email" name="email">
                                                    <span id="email-error" class="text-danger fw-bold d-none"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-theme" data-bs-dismiss="modal">Huỷ bỏ</button>
                                                <button type="submit" form="addform" class="btn btn-theme">Lưu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 my-4">
                            <div class="inline-block text-center">
                                <button type="button" onclick="location.href='{{ route('give_num.index') }}'" class="btn btn-outline-theme">Huỷ bỏ</button>
                                <button type="button" class="addbtn btn btn-theme" data-bs-target="#modal">In số</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('custom_scripts')
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/crud/givenum.js') }}"></script>
    <script>
        var href = "{{ url('cap-so/chi-tiet') }}";
    </script>
@stop
