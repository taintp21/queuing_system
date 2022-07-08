@extends('layouts.app')
@section('web-title', 'Dashboard')
@section('page-title', 'Biểu đồ cấp số')
@section('breadcrumbs', 'Dashboard')
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('tempus-dominus/tempus-dominus.css') }}">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-3 fa-stack fa-2x">
                            <i class="fa fa-circle fa-stack-2x icon-background-1"></i>
                            <i class="fa-regular fa-calendar fa-stack-1x icon-color-1"></i>
                        </div>
                        <div class="col-xl-6 col-lg-9 pt-2">
                            <div class="db-center">
                                <h5 class="fw-bold color-3 truncated-2">Số thứ tự đã cấp</h5>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="fw-bold color-3">{{ $dacap }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-3 fa-stack fa-2x">
                            <i class="fa fa-circle fa-stack-2x icon-background-2"></i>
                            <i class="fa-regular fa-calendar-check fa-stack-1x icon-color-2"></i>
                        </div>
                        <div class="col-xl-6 col-lg-9 pt-2">
                            <div class="db-center">
                                <h5 class="fw-bold color-3 truncated-2">Số thứ tự đã sử dụng</h5>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="fw-bold color-3">{{ $used }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-3 fa-stack fa-2x">
                            <i class="fa fa-circle fa-stack-2x icon-background-3"></i>
                            <i class="fa-regular fa-clock fa-stack-1x icon-color-3"></i>
                        </div>
                        <div class="col-xl-6 col-lg-9 pt-2">
                            <div class="db-center">
                                <h5 class="fw-bold color-3 truncated-2">Số thứ tự đang chờ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="fw-bold color-3">{{ $waiting }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-3 fa-stack fa-2x">
                            <i class="fa fa-circle fa-stack-2x icon-background-4"></i>
                            <i class="bi bi-bookmark-star fa-stack-1x icon-color-4"></i>
                        </div>
                        <div class="col-xl-6 col-lg-9 pt-2">
                            <div class="db-center">
                                <h5 class="fw-bold color-3 truncated-2">Số thứ tự đã bỏ qua</h5>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="fw-bold color-3">{{ $skip }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 my-3">
            <div class="card border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between">
                        <div class="statistical">
                            <h5 class="fw-bold">Bảng thống kê theo ngày</h5>
                            <p class="text-muted">Tháng {{ Carbon\Carbon::now()->format('m/Y') }}</p>
                        </div>
                        <div class="filterChart">
                            <span class="w-100">Xem theo</span>
                            <select id="selectChart" class="form-select" style="width: 97%;">
                                <option value="day">Ngày</option>
                                <option value="week">Tuần</option>
                                <option value="month">Tháng</option>
                            </select>
                        </div>
                    </div>
                    <div class="chartCard">
                        <div class="chartBox">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('tempus-dominus/tempus-dominus.js') }}"></script>
    <script src="{{ asset('chartjs/dist/chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script>
    <script>
        new tempusDominus.TempusDominus(document.getElementById('inlinePicker'), {
            display: {
                viewMode: 'calendar',
                inline: true,
                components: {
                    decades: true,
                    year: true,
                    month: true,
                    date: true,
                    hours: false,
                    minutes: false,
                    seconds: false,
                },
            },
            localization: {
                startOfTheWeek: 1,
            }
        });
    </script>
    <script>
        var date = new Date();
        var currentDay = date.getDate();
        var currentMonth = date.getMonth() + 1;
        if(currentMonth < 10) currentMonth = "0" + currentMonth;
        if(currentDay < 10) currentDay = "0" + currentDay;
        var currentYear = date.getFullYear();
        var formattedDate = currentYear + "-" + currentMonth + "-" + currentDay;
        const day = [
            @for ($i=0; $i<Carbon\Carbon::now()->format("d"); $i++)
                @php $current = Carbon\Carbon::now()->startOfMonth()->addDays($i); $count = 0; @endphp
                @foreach ($days as $day)
                @if ($day->time == $current->format('Y-m-d'))
                    @php $count = 1; @endphp
                @break
                @else
                    @php $count = 0; @endphp
                @endif
                @endforeach
            {
                x: Date.parse("{{ $current->format('Y-m-d') }} 00:00:00 GMT+0700"),
                @if($count == 1) y: {{ $day->count }},
                @else y: 0,
                @endif
            },
            @endfor
        ];
        const week = [
            { x: Date.parse('{{ Carbon\Carbon::now()->subWeek(3)->endOfWeek()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $last3Weeks }} },
            { x: Date.parse('{{ Carbon\Carbon::now()->subWeek(2)->endOfWeek()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $last2Weeks }} },
            { x: Date.parse('{{ Carbon\Carbon::now()->subWeek()->endOfWeek()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $lastWeek }} },
            { x: Date.parse(formattedDate + ' 00:00:00 GMT+0700'), y: {{ $week }} },
        ];

        const month = [
            { x: Date.parse('{{ Carbon\Carbon::now()->subMonth(3)->endOfMonth()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $last3Months }} },
            { x: Date.parse('{{ Carbon\Carbon::now()->subMonth(2)->endOfMonth()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $last2Months }} },
            { x: Date.parse('{{ Carbon\Carbon::now()->subMonth()->endOfMonth()->format("Y-m-d") }} 00:00:00 GMT+0700'), y: {{ $lastMonth }} },
            { x: Date.parse( formattedDate + ' 00:00:00 GMT+0700'), y: {{ $month }} },
        ];
        // setup
        const data = {
            //labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                data: day,
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                borderWidth: 1,
            }]
        };

        // config
        const config = {
            type: 'line',
            maintainAspectRatio: false,
            data,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 5
                        }
                    },
                    y: {
                        beginAtZero: true,
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        },
                    }
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }

        };

        // render init block
        const myChart = new Chart(document.getElementById('myChart'), config);

        $(document).ready(function() {
            $("#selectChart").on('change', function() {
                myChart.config.options.scales.x.time.unit = $(this).val();
                if ($(this).val() == 'day') {
                    myChart.config.data.datasets[0].data = day;
                    $(".statistical h5").html("Bảng thống kê theo ngày");
                }
                if ($(this).val() == 'week') {
                    myChart.config.data.datasets[0].data = week;
                    $(".statistical h5").html("Bảng thống kê theo tuần");
                }
                if ($(this).val() == 'month') {
                    myChart.config.data.datasets[0].data = month;
                    $(".statistical p").html("Năm " + new Date().getFullYear());
                    $(".statistical h5").html("Bảng thống kê theo tháng");
                }
                myChart.update();
            });
        });
    </script>
@stop
