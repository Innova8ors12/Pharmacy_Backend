@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Withdrawal Requests</h2>
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

            </div>
        </div>
    </div>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Withdrawal Requests <i
                                class="bi bi-info-circle"></i></h4>
                        <div class="cover-datatable">
                            <table class="table align-middle" id="userdatatable">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Pharmacy</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                         <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraw as $withdrawal)
                                        <tr>
                                            <td>{{ $loop->iteration }} </td>
                                            <td>{{ $withdrawal->pharmacy->pharmacy_name }}</td>
                                            <td>{{ $withdrawal->amount }}$</td>
                                            <td>{{ $withdrawal->status }}</td>
                                             <td>{{ $withdrawal->created_at->format('d M Y') }}</td>
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
                                                                    <a href="{{ route('admin.withdraw.details', $withdrawal->id) }}"
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
