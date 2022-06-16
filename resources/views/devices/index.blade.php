@extends('layouts.app')
@section('web-title','Thiết bị')
@section('page-title', 'Danh sách thiết bị')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@stop

@section('content')
    <div class="col-md-11">
        <div class="row mb-3">
            <div class="col-md-2 status">
                <label for="status">Trạng thái hoạt động</label>
                <select name="" id="status" class="form-select">
                    <option value="0">Tất cả</option>
                    <option value="1">Hoạt động</option>
                    <option value="2">Ngưng hoạt động</option>
                </select>
            </div>
            <div class="col-md-2 connection">
                <label for="connection">Trạng thái kết nối</label>
                <select name="" id="connection" class="form-select">
                    <option value="0">Tất cả</option>
                    <option value="1">Kết nối</option>
                    <option value="2">Mất kết nối</option>
                </select>
            </div>
            <div class="col-md-2 ms-auto search">
                <label for="search">Từ khoá</label>
                <div class="search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                </div>
            </div>
        </div>
        <div class="fixed-box">
            <a href="{{ route('devices.create') }}">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <br> Thêm <br> thiết bị
            </a>
        </div>
        <table class="table table-bordered rounded-3" id="devices">
            <thead>
                <tr>
                    <th>Mã thiết bị</th>
                    <th>Tên thiết bị</th>
                    <th>Địa chỉ IP</th>
                    <th>Trạng thái hoạt động</th>
                    <th>Trạng thái kết nối</th>
                    <th>Dịch vụ sử dụng</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td><span>{{$item->device_code}}</span></td>
                        <td><span>{{$item->device_name}}</span></td>
                        <td><span>{{$item->ip_address}}</span></td>
                        <td>
                            <span>
                                @if($item->status == 0) <i class="fa-solid fa-circle fa-2xs" style="color: #34CD26;"></i> Hoạt động
                                @elseif($item->status == 1) <i class="fa-solid fa-circle fa-2xs" style="color: #EC3740;"></i> Ngưng hoạt động
                                @endif
                            </span>
                        </td>
                        <td>
                            <span>
                                @if($item->connection == 0) <i class="fa-solid fa-circle fa-2xs" style="color: #34CD26;"></i> Kết nối
                                @elseif($item->connection == 1) <i class="fa-solid fa-circle fa-2xs" style="color: #EC3740;"></i> Mất kết nối
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 250px;">{{$item->description}}</span> <br>
                            <a href="">Xem thêm</a>
                        </td>
                        <td><a href="{{ route('devices.show', ['id'=> $item->id]) }}">Chi tiết</a></td>
                        <td><a href="{{ route('devices.edit', ['id'=>$item->id]) }}">Cập nhật</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
@section('custom_scripts')
    <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            // var table = $('#devices').DataTable();   //pay attention to capital D, which is mandatory to retrieve "api" datatables' object, as @Lionel said
            // $('#search').keyup(function(){
            //     DataTable.draw() ;
            // });
            $("#devices").DataTable({
                ordering: false,
                bLengthChange: false,
                retrieve: true,
                paging: true,
                searching: false,
                "language": {
                    "paginate": {
                        "previous" : '<i class="bi bi-caret-left-fill"></i>',
                        "next" : '<i class="bi bi-caret-right-fill"></i>'
                    }
                }
            });
        });
    </script>
@stop
