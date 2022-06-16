@extends('layouts.app')
@section('web-title','Vai trò')
@section('page-title', 'Danh sách vai trò')

@section('content')
    <div class="col-md-11">
        <div class="fixed-box">
            <a href="{{ route('system.roles.create') }}">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <br> Thêm <br> vai trò
            </a>
        </div>
        <table class="table table-bordered rounded-3">
            <thead>
                <tr>
                    <th>Tên vai trò</th>
                    <th>Số người dùng</th>
                    <th>Mô tả</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td><span>{{ $item->role_name }}</span></td>
                        <td><span>{{ DB::table('users')->where('roles_id', $item->id)->count() }}</span></td>
                        <td><span>{{ $item->description }}</span></td>
                        <td><a href="{{ route('system.roles.edit', ['id'=>$item->id]) }}">Cập nhật</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No record</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@stop
