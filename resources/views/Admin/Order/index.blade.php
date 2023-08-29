@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Orders</h2>
    </div>
    <br>
    <div class="row align-items-end justify-content-between">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div class="search-bar">
                    <form action="">
                        <div class="form-group position-relative mb-0 ">
                            <div class=" dataTables_filter">
                                <input type="search" class="form-control" placeholder="Search keyword" id="custom-filter">
                                <i class="material-icons">
                                    search
                                </i>
                            </div>
                        </div>
                    </form>
                </div>
                <!--<div class="arrow-down flex-6 ">-->
                <!--    <input type="text" name="daterange" value="01/01/2018 - 01/15/2018"-->
                <!--        class="form-control border-radius-50px ps-4 " />-->
                <!--</div>-->
            </div>
        </div>
        <!--<div class="col-md-2">-->
        <!--    <div class="form-group">-->
        <!--        <label for="" class="font-weight-600">Status</label>-->
        <!--        <select name="" id="" class="form-control">-->
        <!--            <option value="1">All</option>-->
        <!--            <option value="1">Picked up</option>-->
        <!--            <option value="1">Delivered</option>-->

        <!--        </select>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
    <div class="cover-inner-content">
        <div class="row">
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
                                    @foreach ($order as $orders)
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
                                            <td>{{ $orders->created_at->format('d M Y') }}</td>
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
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
