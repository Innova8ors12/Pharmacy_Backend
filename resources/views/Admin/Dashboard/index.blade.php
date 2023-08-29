@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Dashboard</h2>
    </div>
    <div class="cover-inner-content">
        <div class="row">
     <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-infos">
                                <p class="text-muted">Total Orders</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>{{$totalorder}}</h4>
                                       
                                    </div>
                                     <div>
                                        <img src="{{asset('public/panel/assets/images/chart3.svg')}}" alt="">
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
                                <p class="text-muted">Total Revenue</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>{{number_format($earning)}}$</h4>
                                       
                                    </div>
                                     <div>
                                        <img src="{{asset('public/panel/assets/images/chart3.svg')}}" alt="">
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
                                <p class="text-muted">Total Users</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h4>{{$totaluser}}</h4>
                                     
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
                                            <td>{{ isset($orders->pharmacy) ? $orders->pharmacy->pharmacy_name : '' }}</td>
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
        <div class="row">
              <div class="col-md-4">
                <div class="card">
                    <div class="card-body gradient-layer">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">New users <i class="bi bi-info-circle"></i></h4>
                        <div class="list-items-v1 fixed-height-270px">
                            <ul>
                                @foreach($recentuser as $recentusers)
                                 <li>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="green-dot green-dot-none">
                                                 @if($recentusers->user_image !=  '')
                                                     <img src="{{asset($recentusers->user_image)}}" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @else
                                                     <img src="https://icon-library.com/images/no-user-image-icon/no-user-image-icon-0.jpg" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @endif
                                            </div>
                                            <p>{{ucwords($recentusers->firstname.' '.$recentusers->lastname)}}</p>
                                        </div>
                                        <p>{{$recentusers->country}}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
              <div class="col-md-4">
                <div class="card">
                    <div class="card-body gradient-layer">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">New Pharmacies <i class="bi bi-info-circle"></i></h4>
                        <div class="list-items-v1 fixed-height-270px">
                            <ul>
                                @foreach($recentpharmacy as $recentpharmacies)
                                 <li>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="green-dot green-dot-none">
                                                 @if($recentpharmacies->image !=  '')
                                                     <img src="{{asset($recentpharmacies->image)}}" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @else
                                                     <img src="https://icon-library.com/images/no-user-image-icon/no-user-image-icon-0.jpg" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @endif
                                            </div>
                                            <p>{{ucwords($recentpharmacies->pharmacy_name)}}</p>
                                        </div>
                                        <p>{{$recentpharmacies->country}}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
       
            
            
    </div>
    @include('Admin.Partials.script')
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

