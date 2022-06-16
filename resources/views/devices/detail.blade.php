@extends('layouts.app')
@section('web-title', 'Chi tiết thiết bị')
@section('page-title', 'Quản lý thiết bị')
@section('custom_css')
    <style>
        .row div p span{
            position: relative;
            font-weight: 700;
        }
        .row div p span{
            display: inline-block;
            width: 150px;
        }
        .description{
            word-break: break-all;
        }
    </style>
@stop
@section('content')
    <div class="content">
        <div class="fixed-box">
            <a href="{{ route('devices.edit', ['id'=>$data->id]) }}">
                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i> <br> Cập nhật thiết bị
            </a>
        </div>
        <h4 class="mb-4 fw-bold color-1">Thông tin thiết bị</h4>
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
@stop
