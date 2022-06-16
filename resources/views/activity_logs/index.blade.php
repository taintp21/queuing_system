@extends('layouts.app')
@section('web-title','Nhật ký hoạt động')
@section('page-title', 'Nhật ký hoạt động')
@section('content')
    <div class="col-md-11">
        <table class="table table-bordered rounded-3">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Thời gian tác động</th>
                    <th>IP thực hiện</th>
                    <th>Thao tác thực hiện</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                        <td><span></span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No record</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@stop
