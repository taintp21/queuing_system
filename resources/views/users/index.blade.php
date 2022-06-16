@extends('layouts.app')
@section('web-title','Tài khoản')
@section('page-title', 'Danh sách tài khoản')

@section('content')

    <div class="col-md-11">
        <div class="row mb-3">
            <div class="col-md-2 connection">
                <label for="connection">Tên vai trò</label>
                <select name="" id="connection" class="form-select">
                    @foreach ($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 ms-auto search">
                <label for="search">Từ khoá</label>
                <form action="" class="search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                </form>
            </div>
        </div>
        <div class="fixed-box">
            <a href="{{ route('system.users.create') }}">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <br> Thêm <br> tài khoản
            </a>
        </div>
        <table class="table table-bordered rounded-3">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Trạng thái hoạt động</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td><span>{{$item->username}}</span></td>
                        <td><span>{{$item->name}}</span></td>
                        <td><span>{{$item->phone}}</span></td>
                        <td><span>{{$item->email}}</span></td>
                        <td><span>{{$item->role->role_name}}</span></td>
                        <td>
                            <span>
                                @if($item->status == 0) <i class="fa-solid fa-circle fa-2xs" style="color: #34CD26;"></i> Hoạt động
                                @elseif($item->status == 1) <i class="fa-solid fa-circle fa-2xs" style="color: #EC3740;"></i> Ngưng hoạt động
                                @endif
                            </span>
                        </td>
                        <td><a href="{{ route('system.users.edit', ['id'=>$item->id]) }}">Cập nhật</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
