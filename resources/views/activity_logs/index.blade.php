@extends('layouts.app')
@section('web-title','Nhật ký hoạt động')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop
@section('content')
    <div class="col-md-11">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-md-6 col-sm-6 mb-3">
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
            <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6 ms-auto mb-3 search">
                <label for="search">Từ khoá</label>
                <div class="search-form">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" id="search" placeholder="Nhập từ khoá">
                </div>
            </div>
            <div class="col-12">
                <table class="table table-bordered rounded-3" id="table">
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
                            <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->created_at->format("d/m/Y H:i:s") }}</td>
                                <td>{{ $item->ip_address }}</td>
                                <td>{!! $item->description !!}</td>
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
<script src="{{ asset("js/moment.js") }}"></script>
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
            $.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
                var min = moment($("#fromDate").val()).isValid() ? new Date($("#fromDate").val()).setUTCHours(0,0,0,0) : null;
                var max = moment($("#toDate").val()).isValid() ? new Date($("#toDate").val()).setUTCHours(23,59,59,999) : null;
                var date = new Date( data[1] ).setHours(0,0,0);
                console.log(min);
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
