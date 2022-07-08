@extends('layouts.app')
@section('web-title', 'Danh sách dịch vụ')
@section('page-title', 'Quản lý dịch vụ')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop
@section('content')
    <div class="col-md-11">
        <div class="col-12">
            <a href="{{ route('services.create') }}" class="fixed-box text-decoration-none">
                <i class="bi bi-plus-square-fill" style="font-size: 1.5rem;"></i> <p>Thêm dịch vụ</p>
            </a>
        </div>
        <div class="row">
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 mb-3 status">
                <label for="status">Trạng thái hoạt động</label>
                <select id="status" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="Hoạt động">Hoạt động</option>
                    <option value="Ngưng hoạt động">Ngưng hoạt động</option>
                </select>
            </div>
            <div class="col-xxl-4 col-xl-5 col-md-4 col-sm-6 mb-3">
                <label>Chọn thời gian</label>
                <div class="row g-4 date">
                    <div class="col date-from">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="text" class="form-control" id="fromDate" placeholder="10/10/2022">
                    </div>

                    <div class="col date-to">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="text" class="form-control" id="toDate" placeholder="18/10/2022">
                    </div>
                </div>
            </div>
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-12 ms-auto mb-3 search">
                <label for="search">Từ khoá</label>
                <div class="search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                </div>
            </div>
            <div class="col-12">
                <table class="table table-bordered rounded-3" width="100%" id="table">
                    <thead>
                        <tr>
                            <th>Mã dịch vụ</th>
                            <th>Tên dịch vụ</th>
                            <th>Mô tả</th>
                            <th>Trạng thái hoạt động</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $item)
                            <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                <td>{{ $item->service_code }}</td>
                                <td>{{ $item->service_name }}</td>
                                <td>{{ $item->description }}</td>
                                @if ($item->status == 0)
                                <td>Hoạt động</td>
                                @else
                                <td>Ngưng hoạt động</td>
                                @endif
                                <td><a href="{{ route('services.show', ['id' => $item->id]) }}">Chi tiết</a></td>
                                <td><a href="{{ route('services.edit', ['id' => $item->id]) }}">Cập nhật</a></td>
                                <td>{{ $item->created_at->format("d/m/Y H:i:s") }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="6">No records found</td>
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
<script src="{{ asset("js/moment.js") }}"></script>
<script>
    $(document).ready(function(){
        var table = $("#table").DataTable({
            pageLength: 10,
            ordering: false,
            responsive: true,
            columnDefs: [
                {
                    target: 6,
                    className: 'never',
                },
                {
                    target: 3,
                    createdCell: function(td, cellData, rowData, row, col){
                        switch (cellData){
                            case 'Hoạt động': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-active"></i> '); break;
                            case 'Ngưng hoạt động': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-inactive"></i> '); break;
                        }
                    }
                },
            ],
            initComplete: function () {
                this.api().columns(3).every(function () {
                    var column = this;
                    var select = $("#status").on('change', function () {
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
        $("#search").on("keyup", function() {
            table.search($(this).val()).draw();
        });
        $.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
            var min = moment($("#fromDate").val()).isValid() ? new Date($("#fromDate").val()).setUTCHours(0,0,0,0) : null;
            var max = moment($("#toDate").val()).isValid() ? new Date($("#toDate").val()).setUTCHours(23,59,59,999) : null;
            var date = new Date( data[6] ).setHours(0,0,0);
            if(min == null && max == null) return true;
            if(min == null && date <= max) return true;
            if(min <= date && max == null) return true;
            if(min <= date && date <= max) return true;
            return false;
        });
        new DateTime($('#fromDate'), {
            format: 'DD/MM/YYYY',
            def: function() {return new Date().setHours(0,0,0);},
            i18n: {
                weekdays: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            }
        });
        new DateTime($('#toDate'), {
            format: 'DD/MM/YYYY',
            def: function() {return new Date().setHours(23,59,59);},
            i18n: {
                weekdays: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            }
        });
        $('#fromDate, #toDate').on("change", function() {
            table.draw();
        });
    });
</script>
@stop
