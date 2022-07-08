@extends('layouts.app')
@section('web-title','Tài khoản')
@section('page-title', 'Danh sách tài khoản')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop

@section('content')
    <div class="col-md-11">
        <div class="col-12">
            <a href="{{ route('system.users.create') }}" class="fixed-box text-decoration-none">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <p>Thêm tài khoản</p>
            </a>
        </div>
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 mb-3">
                <label for="role">Tên vai trò</label>
                <select id="role" class="form-select">
                    <option value="">Tất cả</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r->role_name }}">{{ $r->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 ms-auto mb-3 search">
                <label for="search">Từ khoá</label>
                <div class="search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                </div>
            </div>

            <div class="col-12 table-responsive">
                <table class="table table-bordered rounded-3" id="table">
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
                        @forelse ($data as $item)
                            <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                <td><span>{{$item->username}}</span></td>
                                <td><span>{{$item->name}}</span></td>
                                <td><span>{{$item->phone}}</span></td>
                                <td><span>{{$item->email}}</span></td>
                                <td><span>{{$item->role->role_name}}</span></td>
                                @if ($item->status == 0)
                                    <td class="icon-active">Hoạt động</td>
                                @else
                                    <td class="icon-inactive">Ngưng hoạt động</td>
                                @endif
                                <td><a href="{{ route('system.users.edit', ['id'=>$item->id]) }}">Cập nhật</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No record found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('custom_scripts')
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            var table = $("#table").DataTable({
                pageLength: 10,
                ordering: false,
                initComplete: function () {
                    this.api().columns(4).every(function () {
                        var column = this;
                        var select = $("#role").on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false).draw();
                            });
                    });
                },
                fnDrawCallback: function (oSettings) {
                    var pgr = $(oSettings.nTableWrapper).find('.dataTables_paginate')
                    if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                        pgr.hide();
                    } else {
                        pgr.show();
                    }
                }
            });
            $(".icon-active").prepend('<i class="fa-solid fa-circle fa-2xs color-active"></i> ');
            $(".icon-inactive").prepend('<i class="fa-solid fa-circle fa-2xs color-inactive"></i> ');
            $("#search").on("keyup", function() {
                table.search($(this).val()).draw();
            });
        });
    </script>
@stop
