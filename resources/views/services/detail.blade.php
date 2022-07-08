@extends('layouts.app')
@section('web-title', 'Chi tiết')
@section('page-title', 'Quản lý dịch vụ')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
<style>
    p span{
        position: relative;
        font-weight: 700;
    }
    p span{
        display: inline-block;
        width: 100px;
    }
    .form-check-input, .form-check-label{
        margin-right: .5rem;
    }
    .form-check-input{
        margin-top: 0!important;
    }
    input:disabled{
        background-color: white!important;
        color: unset!important;
        opacity: 1!important;
    }
</style>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5 class="fw-bold color-1">Thông tin dịch vụ</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><span>Mã dịch vụ:</span>{{ $service->service_code }}</p>
                                    <p><span>Tên dịch vụ:</span>{{ $service->service_name }}</p>
                                    <p><span>Mô tả:</span>{{ $service->description }}</p>
                                </div>
                            </div>
                        </div>
                        @if ($service->number_from != null || $service->number_to != null || $service->prefix != null || $service->surfix != null)
                        <div class="col-md-12 mb-3">
                            <h5 class="fw-bold color-1">Quy tắc cấp số</h5>
                        </div>
                        @endif
                        @if ($service->number_from != null || $service->number_to != null)
                        <div class="col-md-12 mb-3 d-flex align-items-center">
                            @if ($service->number_from != null)
                            <label for="increase_number" class="form-check-label me-4">Tăng tự động từ:</label>
                            <input type="number" class="form-control" style="max-width: 80px;" disabled value="{{ $service->number_from }}">
                            @endif
                            @if ($service->number_to != null)
                            <label class="mx-3">đến</label>
                            <input type="number" class="form-control" style="max-width: 80px;" disabled value="{{ $service->number_to }}">
                            @endif
                        </div>
                        @endif

                        @if ($service->prefix != null)
                        <div class="col-md-12 mb-3 d-flex align-items-center align-self-center">
                            <label for="prefix" class="form-check-label me-5">Prefix:</label>
                            <input type="number" class="form-control ms-5" style="max-width: 80px;" disabled value="{{ $service->prefix }}">
                        </div>
                        @endif

                        @if ($service->surfix != null)
                        <div class="col-md-12 mb-3 d-flex align-items-center align-self-center">
                            <label for="surfix" class="form-check-label me-5">Surfix:</label>
                            <input type="number" class="form-control ms-5" style="max-width: 80px;" disabled value="{{ $service->surfix }}">
                        </div>
                        @endif

                        @if ($service->reset == 0)
                        <div class="col-md-12 mb-3">
                            <label for="prefix" class="form-check-label me-5">Reset mỗi ngày</label>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-xl-3 col-md-3 col-sm-12 mb-3">
                            <label for="status">Trạng thái</label>
                            <select id="status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="Đã hoàn thành">Đã hoàn thành</option>
                                <option value="Đang thực hiện">Đang thực hiện</option>
                                <option value="Vắng">Vắng</option>
                            </select>
                        </div>
                        <div class="col-xl-6 col-md-5 col-sm-12 mb-3">
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
                        <div class="col-xl-3 col-md-4 col-sm-12 ms-auto mb-3 search">
                            <label for="search">Từ khoá</label>
                            <div class="search-form">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" id="table">
                                <thead>
                                    <tr>
                                        <th>Số thứ tự</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse ($service->give_num as $give_num)
                                    <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                        <td>{{ $give_num->order }}</td>
                                        @if ($give_num->status == 0)
                                        <td>Đang thực hiện</td>
                                        @elseif ($give_num->status == 1)
                                        <td>Đã hoàn thành</td>
                                        @else
                                        <td>Vắng</td>
                                        @endif
                                        </td>
                                        <td>{{ $give_num->created_at->format("d/m/Y H:i:s") }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="2">No records found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                    target: 2,
                    className: 'never',
                },
                {
                    target: 1,
                    createdCell: function(td, cellData, rowData, row, col){
                        switch (cellData){
                            case 'Đang thực hiện': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-waiting"></i> '); break;
                            case 'Đã hoàn thành': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-used"></i> '); break;
                            case 'Vắng': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-skip"></i> '); break;
                        }
                    }
                },
            ],
            initComplete: function () {
                this.api().columns(1).every(function () {
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
            var date = new Date( data[2] ).setHours(0,0,0);
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
