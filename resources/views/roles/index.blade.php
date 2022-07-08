@extends('layouts.app')
@section('web-title','Vai trò')
@section('page-title', 'Danh sách vai trò')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop

@section('content')
    <div class="col-md-11">
        <div class="col-12">
            <a href="{{ route('system.roles.create') }}" class="fixed-box text-decoration-none">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <p>Thêm vai trò</p>
            </a>
        </div>
        <div class="row">
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
                            <th>Tên vai trò</th>
                            <th>Số người dùng</th>
                            <th>Mô tả</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                <td><span>{{ $role->role_name }}</span></td>
                                <td><span>{{ $role->users_count }}</span></td>
                                <td><span>{{ $role->description }}</span></td>
                                <td><a href="{{ route('system.roles.edit', ['id'=>$role->id]) }}">Cập nhật</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No record</td>
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
                fnDrawCallback: function (oSettings) {
                    var pgr = $(oSettings.nTableWrapper).find('.dataTables_paginate')
                    if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                        pgr.hide();
                    } else {
                        pgr.show();
                    }
                }
            });
            $("#search").on("keyup", function() {
                table.search($(this).val()).draw();
            });
        });
    </script>
@stop
