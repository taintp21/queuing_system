@extends('layouts.app')
@section('web-title', 'Chi tiết thiết bị')
@section('page-title', 'Quản lý thiết bị')
@section('custom_css')
    <style>
        p span{
            position: relative;
            font-weight: 700;
        }
        p span{
            display: inline-block;
            width: 150px;
        }
        .description{
            word-break: break-all;
        }
        .card-body{
            min-height: 700px;
        }
    </style>
@stop
@section('content')
    <div class="col-md-11">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('devices.edit', ['id'=>$data->id]) }}" class="fixed-box text-decoration-none color-1 fw-bold">
                    <i class="bi bi-pencil" style="font-size: 1.5rem;"></i> <p>Cập nhật thiết bị</p>
                </a>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-4 fw-bold color-1">Thông tin thiết bị</h5>
                        <div class="row">
                            <div class="col-md-5">
                                <p><span>Mã thiết bị:</span>{{$data->device_code}}</p>
                                <p><span>Tên thiết bị:</span>{{$data->device_name}}</p>
                                <p><span>Địa chỉ IP:</span>{{$data->ip_address}}</p>
                            </div>
                            <div class="col-md-5">
                                <p><span>Loại thiết bị:</span>{{$data->device_type}}</p>
                                <p><span>Tên đăng nhập:</span>{{$data->username}}</p>
                                <p><span>Mật khẩu:</span>{{$data->password}}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p><span>Dịch vụ sử dụng:</span></p>
                            <span class="description">{{$data->description}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
