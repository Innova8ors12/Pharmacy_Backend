@extends('Admin.Dashboard.index')
@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <div class="cover-all-content">
        <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
            <h2>Reports</h2>

        </div>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="arrow-down flex-6 ">
                    <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"
                        class="form-control border-radius-50px ps-4 " />
                </div>
            </div>
        </div>
        <br>

        <div class="cover-inner-content">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-infos">
                                <p class="text-muted">Total orders</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>{{$totalorder}}</h4>
                                        <p class="decrement-text"><i class="material-icons">
                                                arrow_downward
                                            </i> 13.8%</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('public/panel/assets/images/chart1.svg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-infos">
                                <p class="text-muted">Total revenue</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>2453</h4>
                                        <p class="increment-text"><i class="material-icons">
                                                arrow_upward
                                            </i> 20.8%</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('public/panel/assets/images/chart2.svg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-infos">
                                <p class="text-muted">Total Earnings</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>${{$earning}}</h4>
                                        <p class="decrement-text"><i class="material-icons">
                                                arrow_downward
                                            </i> 13.8%</p>
                                    </div>
                                    <div>
                                        <img src="{{asset('public/panel/assets/images/chart3.svg')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title d-flex align-itesms-center justify-content-between">Sales statistics <i
                                    class="bi bi-info-circle"></i></h4>
                        </div>
                        <div class="cover-chart">
                            <div class="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title d-flex align-itesms-center justify-content-between">Orders <i
                                    class="bi bi-info-circle"></i></h4>
                            <div class="cover-datatable">
                                <table class="table align-middle" id="userdatatable">
                                    <thead>
                                        <tr>
                                            <th>Placed by </th>
                                            <th>Placed at</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($recent as $orders)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2 ps-4">
                                                    <div class="green-dot green-dot-none">
                                                        <img src="{{ asset($orders->user->user_image) }}"
                                                            class="border-radius-50px" alt=""
                                                            style="width: 45px; height: 45px; object-fit: cover">
                                                    </div>
                                                    <p class="m-0 font-weight-600 text-black">
                                                        {{ ucfirst($orders->user->username) }}</p>
                                                </div>
                                            </td>
                                            <td>{{ $orders->pharmacy->pharmacy_name }}</td>
                                            <td>{{ $orders->created_at->format('D M Y') }}</td>
                                            <td>{{ $orders->created_at->format('h:i a') }}</td>
                                            <td>{{ $orders->total_amount }}$</td>
                                            <td>{{ $orders->delivery_status }}</td>
                                            <td>
                                                <div class="cover-table-btn">
                                                    <ul>
                                                        <li class="dropdown position-relative">
                                                            <a href="#" class="dropdown-toggle caret-none"
                                                                data-bs-toggle="dropdown" role="button"
                                                                id="navbarDropdown"><i class="material-icons">
                                                                    more_vert
                                                                </i></a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="navbarDropdown">
                                                                <li>
                                                                    <a href="{{ route('admin.order.details', $orders->id) }}"
                                                                        class="dropdown-item">Details</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include('Admin.Partials.script')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
                )
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
                )
            window.Promise ||
                document.write(
                    '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
                )
        </script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                        .format('YYYY-MM-DD'));
                });
            });

            var options = {
                series: [{
                    name: 'series1',
                    data: [31, 40, 28, 51, 42, 109, 100]
                }, {
                    name: 'series2',
                    data: [11, 32, 45, 32, 34, 52, 41]
                }],
                chart: {
                    height: 270,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                        "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                        "2018-09-19T06:30:00.000Z"
                    ]
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            };
            var chart = new ApexCharts(document.querySelector(".chart1"), options);
            chart.render();
        </script>
    @endsection
