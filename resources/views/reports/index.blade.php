@extends('layouts.app')
@section('web-title','Lập báo cáo')
@section('custom_css')
<link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}">
@stop
@section('content')
    <div class="col-md-11">
        <div class="col-12">
            <button type="button" class="fixed-box text-decoration-none">
                <i class="fa-solid fa-file-arrow-down" style="font-size: 1.5rem;"></i> <p>Tải về</p>
            </button>
        </div>
        <div class="col-xxl-4 col-xl-5 col-md-6 col-sm-6">
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
        <div class="col-12 table-responsive">
            <table class="table table-bordered rounded-3" width="100%" id="table">
                <thead>
                    <tr>
                        <th>Số thứ tự</th>
                        <th>Tên dịch vụ</th>
                        <th>Thời gian cấp</th>
                        <th>Tình trạng</th>
                        <th>Nguồn cấp</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($baocao as $item)
                        <tr class="@if ($loop->even) background-3 @else bg-white @endif">
                            <td>{{ $item->order }}</td>
                            <td>{{ $item->services->service_name }}</td>
                            <td>{{ $item->created_at->format("H:i - d/m/Y") }}</td>
                            @if ($item->status == 0)
                            <td>Đang chờ</td>
                            @elseif ($item->status == 1)
                            <td>Đã sử dụng</td>
                            @else
                            <td>Bỏ qua</td>
                            @endif
                            <td>{{ $item->supply }}</td>
                            <td>{{ $item->created_at->format("d/m/Y H:i:s") }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="5">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
            dom: 'Bfrtip',
            buttons: [
                {
                    text: 'Tải về',
                    extend: 'pdfHtml5',
                    title: 'Báo cáo',
                    download: 'open',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: ':visible',
                    },
                    customize: function(doc) {
                        //Center table in PDF
                        doc.styles.tableHeader.alignment = 'left';
                        var colCount = new Array();
                        $("#table").find('tbody tr:first-child td').each(function(){
                            if($(this).attr('colspan')){
                                for(var i=1;i<=$(this).attr('colspan');$i++){
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });
                        doc.content[1].table.widths = colCount;

                        doc.content[1].margin = [ 80, 0, 0, 0 ]; //left, top, right, bottom
                        doc.content[1].padding = [300, 0, 0, 0];
                    },
                },
            ],
            columnDefs: [
                {
                    target: 5,
                    className: 'never',
                },
                {
                    target: 3,
                    createdCell: function(td, cellData, rowData, row, col){
                        switch (cellData){
                            case 'Đang chờ': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-waiting"></i> '); break;
                            case 'Đã sử dụng': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-used"></i> '); break;
                            case 'Bỏ qua': $(td).prepend('<i class="fa-solid fa-circle fa-2xs color-skip"></i> '); break;
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
            }
        });
        $(".item_waiting").prepend('<i class="fa-solid fa-circle fa-2xs color-waiting"></i> ');
        $(".item_used").prepend('<i class="fa-solid fa-circle fa-2xs color-used"></i> ');
        $(".item_skip").prepend('<i class="fa-solid fa-circle fa-2xs color-skip"></i> ');

        $.fn.dataTable.ext.search.push(function( settings, data, dataIndex ) {
            var min = moment($("#fromDate").val()).isValid() ? new Date($("#fromDate").val()).setUTCHours(0,0,0,0) : null;
            var max = moment($("#toDate").val()).isValid() ? new Date($("#toDate").val()).setUTCHours(23,59,59,999) : null;
            var date = new Date( data[5] ).setHours(0,0,0);
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

        $("button.fixed-box").on("click", function(){
            $(".buttons-pdf.buttons-html5").trigger("click");
        });
    });
</script>
@stop
