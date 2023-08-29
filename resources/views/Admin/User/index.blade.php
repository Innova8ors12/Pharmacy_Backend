@extends('Admin.Layouts.master')
@section('content')
 <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>App users</h2>
    </div>
    <br>
    <div class="row align-items-end justify-content-between">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div class="search-bar ">
                    <form action="">
                        <div class="form-group position-relative mb-0 ">
                            <div class=" dataTables_filter">
                                <input type="search" class="form-control" placeholder="Search keyword"
                                    id="custom-filter">
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
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Users Manager <i
                                class="bi bi-info-circle"></i></h4>
                        <div class="cover-datatable">
                            <table class="table align-middle" id="userdatatable">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Country</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                        <!--<th>In app purchases</th>-->
                                    </tr>
                                </thead>
                                 <tbody>
                                     @foreach ($customer  as $users)
                                        <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 ps-4">
                                                <div class="green-dot green-dot-none">
                                                    @if($users->user_image !=  '')
                                                     <img src="{{asset($users->user_image)}}" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @else
                                                     <img src="https://icon-library.com/images/no-user-image-icon/no-user-image-icon-0.jpg" class="border-radius-50px" alt=""
                                                        style="width: 45px; height: 45px; object-fit: cover">
                                                    @endif
                                                   
                                                </div>
                                                <p class="m-0 font-weight-600 text-black">{{$users->username}}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{$users->country}}
                                            </div>
                                        </td>
                                        <td>
                                             {{$users->email}}
                                        </td>
                                        <td>  {{$users->phone}}</td>
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
                                                                <a href="{{ route('admin.user.delete', ['id' => $users->id]) }}" class="dropdown-item">Delete</a>
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
