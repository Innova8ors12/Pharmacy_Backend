@extends('Admin.Layouts.master')
@section('content')

    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Riders Report</h2>
    </div>
    <br>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Rider Report <i
                                class="bi bi-info-circle"></i></h4>
                    <div class="row g-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <h3 class="card-title">
                                Orders Completed
                            </h3>
                            <!--<select id="changeChartFilter" class="select-box select2Height-40px" data-placeholder="Select..."-->
                            <!--    data-minimum-results-for-search="Infinity" style=" max-width: 150px">-->
                            <!--    <option></option>-->
                            <!--    <option>Total</option>-->
                            <!--    <option>Last 24 Hours</option>-->
                            <!--    <option>Last 7 Days</option>-->
                            <!--    <option>Last Month</option>-->
                            <!--    <option>Last 3 Months</option>-->
                            <!--    <option>Last 6 Months</option>-->
                            <!--    <option>Last 12 Months</option>-->
                            <!--</select>-->
                        </div>
                        <br>
                        <div id="chart"></div>
                        <!--<h3 class=" position-absolute top-50 font-18px font-weight-600 m-0 fst-italic"-->
                        <!--    style="writing-mode: tb-rl; transform: translateY(-50%) rotate(180deg);     left: 19px;">New Users</h3>-->
                    </div>
                </div>
            </div>

        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>


 @include('Admin.Partials.script')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
        var revenueChart = @json($dynamicChartData);
            console.log(revenueChart)
            var options = {
                series: [{
                        name: 'REVENUE',
                        data: revenueChart
                    },

                ],
                chart: {
                    id: 'chart',
                    type: 'area',
                    height: 345,
                    zoom: {
                        autoScaleYaxis: false
                    }
                },


                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0,
                    style: 'hollow',
                },
                grid: {
                    borderColor: '#f7f9fa ',
                },
                xaxis: {
                    type: 'datetime',
                    min: new Date('01 Jan 2023').getTime(),
                    axisBorder: {
                        show: true,
                        color: 'rgba(119, 119, 142, 0.05)',
                        offsetX: 0,
                        offsetY: 0,
                    },
                    axisTicks: {
                        show: true,
                        borderType: 'solid',
                        color: 'rgba(119, 119, 142, 0.05)',
                        width: 6,
                        offsetX: 0,
                        offsetY: 0
                    },
                    labels: {
                        show: true,
                        rotate: -90,
                        style: {
                            fontSize: '11px',
                            fontFamily: 'Helvetica, Arial, sans-serif',
                            fontWeight: 400,
                            cssClass: 'apexcharts-xaxis-label',
                        },
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Growth',
                        style: {
                            color: '#adb5be',
                            fontSize: '14px',
                            fontFamily: 'poppins, sans-serif',
                            fontWeight: 600,
                            cssClass: 'apexcharts-yaxis-label',
                        },
                    },
                    labels: {
                        formatter: function(y) {
                            return y.toFixed(0) + "";
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'dd MMM yyy'
                    }
                },
                stroke: {
                    show: true,
                    curve: 'smooth',
                    lineCap: 'butt',
                    colors: undefined,
                    width: 1,
                    dashArray: 0,
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.75,
                        opacityTo: 0.5,
                        stops: [0, 200]
                    }
                },

                legend: {
                    position: "top",
                    show: true
                }
            };
            document.getElementById('chart').innerHTML = '';
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
       
    </script>
@endsection
