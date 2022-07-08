@extends('layouts.app')
@section('web-title', 'Danh sách thiết bị')
@section('page-title', 'Danh sách thiết bị')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop
@section('content')
    <div class="col-md-11">
        <div class="col-12">
            <a href="{{ route('devices.create') }}" class="fixed-box text-decoration-none">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <p>Thêm thiết bị</p>
            </a>
        </div>
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-12 mb-3">
                <label for="status">Trạng thái hoạt động</label>
                <select id="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Hoạt động">Hoạt động</option>
                    <option value="Ngưng hoạt động">Ngưng hoạt động</option>
                </select>
            </div>
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-12 mb-3">
                <label for="connection">Trạng thái kết nối</label>
                <select id="connection" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Kết nối">Kết nối</option>
                    <option value="Mất kết nối">Mất kết nối</option>
                </select>
            </div>
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-12 ms-auto mb-3 search">
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
                            <th>Mã thiết bị</th>
                            <th>Tên thiết bị</th>
                            <th>Địa chỉ IP</th>
                            <th>Trạng thái hoạt động</th>
                            <th>Trạng thái kết nối</th>
                            <th>Dịch vụ sử dụng</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                <td>{{ $item->device_code }}</td>
                                <td>{{ $item->device_name }}</td>
                                <td>{{ $item->ip_address }}</td>
                                @if ($item->status == 0)
                                <td>Hoạt động</td>
                                @else
                                <td>Ngưng hoạt động</td>
                                @endif
                                @if ($item->connection == 0)
                                <td>Kết nối</td>
                                @else
                                <td>Mất kết nối</td>
                                @endif
                                <td>
                                    <span class="truncated">{{ $item->description }}</span>
                                    <a href="#" class="readmore d-none">Xem thêm</a>
                                </td>
                                <td><a href="{{ route('devices.show', ['id' => $item->id]) }}">Chi tiết</a></td>
                                <td><a href="{{ route('devices.edit', ['id' => $item->id]) }}">Cập nhật</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('custom_scripts')
<script src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table = $("#table").DataTable({
            pageLength: 10,
            ordering: false,
            columnDefs: [
                {
                    target: 3,
                    createdCell: function(td, cellData, rowData, row, col){
                        switch (cellData){
                            case 'Hoạt động': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-active"></i> '); break;
                            case 'Ngưng hoạt động': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-inactive"></i> '); break;
                        }
                    }
                },
                {
                    target: 4,
                    createdCell: function(td, cellData, rowData, row, col){
                        switch (cellData){
                            case 'Kết nối': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-active"></i> '); break;
                            case 'Mất kết nối': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-inactive"></i> '); break;
                        }
                    }
                },
            ],
            fnDrawCallback: function (oSettings) {
                var pgr = $(oSettings.nTableWrapper).find('.dataTables_paginate')
                if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                    pgr.hide();
                } else {
                    pgr.show();
                }
            },
            initComplete: function () {
                this.api().columns(3).every(function () {
                    var column = this;
                    var select = $("#status").on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                }),
                this.api().columns(4).every(function () {
                    var column = this;
                    var select = $("#connection").on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                });
            }
        });
        $("#search").on("keyup", function() {
            table.search($(this).val()).draw();
        });
    });
    document.querySelectorAll(".truncated").forEach(function(each){
        if(each.offsetHeight < each.scrollHeight || each.offsetWidth < each.scrollWidth){
            var readmore = each.nextElementSibling;
            readmore.classList.remove("d-none");
            readmore.onclick = function(){
                each.classList.remove('truncated');
                readmore.classList.add("d-none");
            }
        }
    });
</script>
@stop
