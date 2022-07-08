@extends('layouts.app')
@section('web-title', 'Chi tiết')
@section('page-title', 'Quản lý cấp số')
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
                <a href="{{ route('give_num.create') }}" class="fixed-box text-decoration-none color-1 fw-bold">
                    <i class="fa-solid fa-arrow-rotate-left"></i> <p>Quay lại</p>
                </a>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-4 fw-bold color-1">Thông tin cấp số</h5>
                        <div class="row">
                            <div class="col-md-5">
                                <p><span>Họ tên:</span>{{ $data->name }}</p>
                                <p><span>Tên dịch vụ:</span>{{ $data->services->service_name }}</p>
                                <p><span>Số thứ tự:</span>{{ $data->order }}</p>
                                <p><span>Thời gian cấp:</span>{{ $data->created_at->format("H:i - d/m/Y") }}</p>
                                <p><span>Hạn sử dụng:</span>{{ $data->expired_date->format("H:i - d/m/Y") }}</p>
                            </div>
                            <div class="col-md-5">
                                <p><span>Nguồn cấp:</span>{{ $data->supply }}</p>
                                <p>
                                    <span>Trạng thái:</span>@if($data->status == 0)<i class="fa-solid fa-circle fa-2xs color-waiting"></i> Đang chờ @elseif($data->status == 1)<i class="fa-solid fa-circle fa-2xs color-used"></i> Đã sử dụng @elseif($data->status==2)<i class="fa-solid fa-circle fa-2xs color-skip"></i> Bỏ qua @endif
                                </p>
                                <p><span>Số điện thoại:</span>{{ $data->phone }}</p>
                                <p><span>Địa chỉ email:</span>{{ $data->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
