@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Products</h2>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
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
        <div style="display: flex;
    justify-content: right;" class="col-md-9">
            <a href="{{ route('admin.product.create') }}" class="white-btn left-icon font-weight-500"><i
                    class="material-icons">
                    add
                </i> Create Product</a>
        </div>

    </div>

    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Products <i
                                class="bi bi-info-circle"></i></h4>
                        <div class="cover-datatable">
                            <table class="table align-middle" id="userdatatable">
                                <thead>
                                    <tr>

                                        <th>S.no</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $products)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $products->name }}</td>
                                            <td>{{ $products->price }}.00$</td>
                                            <td>
                                                @if ($products->status == 1)
                                                    <span style="    background: #14d389;
    color: white;
    padding: 8px;
    border-radius: 20px;">Active</span>
                                                @else
                                                    <span style="    background: red;
    color: white;
    padding: 8px;
    border-radius: 20px;">Deactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <img style="    height: 65px;
    width: 93px;" class="rounded"
                                                    height="100px" src="{{ $products->main_img }}" alt="">
                                            </td>
                                            <td>
                                                 <div class="cover-table-btn">
                                    <ul>
                                        <li class="dropdown position-relative">
                                            <a href="#" class="dropdown-toggle caret-none" data-bs-toggle="dropdown"
                                                role="button" id="navbarDropdown" aria-expanded="false"><i
                                                    class="material-icons">
                                                    more_horiz
                                                </i></a>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <li>
                                                    <a href=""
                                                        class="dropdown-item">Edit</a>
                                                </li>

                                                <li>
                                                    <a data-id="34" href="#"
                                                        class="dropdown-item delete">Delete</a>
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
@endsection
