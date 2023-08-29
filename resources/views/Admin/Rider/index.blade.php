@extends('Admin.Layouts.master')
@section('content')

    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Riders</h2>
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
    </div>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Riders <i
                                class="bi bi-info-circle"></i></h4>
                        <div class="cover-datatable" style="overflow:auto ">
                            <table class="table align-middle" id="userdatatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Rider</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Account Status</th>
                                        <th>Zone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                        @foreach ($riders as $key => $rider)
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 ps-4">
                                                        <div class="green-dot green-dot-none">
                                                            <img src="{{ asset($rider->lisence) }}"
                                                                class="border-radius-50px" alt=""
                                                                style="width: 45px; height: 45px; object-fit: cover">
                                                        </div>
                                                        <p class="m-0 font-weight-600 text-black">
                                                            {{ $rider->first_name . ' ' . $rider->last_name }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                  {{ $rider->email }}
                                                </td>
                                                <td>{{ $rider->phone }}</td>
                                                <td>
                                                    {{ $rider->address }}
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                         <input class="form-check-input toggle" onChange="changeActve({{$rider->id}})" type="checkbox" data-id="{{$rider->id}}" data-email="{{$rider->email}}"  role="switch" id="flexSwitchCheckDefault" {{$rider->is_active == 1 ? 'checked' : ''}}>
                                                    </div>
                                               </td>
                                                <td>
                                                    {{ isset($rider->getzone) ? $rider->getzone->name : 'Not Assigned' }}
                                                </td>
                                                <td>
                                                    <ul class="dropdownStyle-v1">
                                                        <li class="dropdown tableDropdown">
                                                            <a href="javascript:void(0)" class="dropdown-toggle caret-none"
                                                                data-bs-toggle="dropdown" role="button" id="navbarDropdown"
                                                                aria-expanded="false"><i
                                                                    class="bi bi-three-dots-vertical font-19px link-dark"></i></a>
                                                            <ul class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="navbarDropdown">
                                                                <li>
                                                                    <a href="#."  onclick="assignZone({{ $rider->id }})" 
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                        class="dropdown-item text-primary">
                                                                         @if($rider->zone_id == NULL)
                                                                            Assign Zone
                                                                        @else
                                                                            Re-Assign Zone
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('admin.rider.report', ['id' => $rider->id]) }}"
                                                                        class="dropdown-item text-primary">
                                                                        View Report
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('admin.rider.track', ['id' => $rider->id]) }}"
                                                                        class="dropdown-item text-primary">
                                                                        Track Rider
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>

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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="assignZoneForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="zone_id">
                            <option>Select Rider</option>
                            @foreach(App\Models\Zone::all() as $zone)
                                <option value="{{ $zone->id }}">
                                {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                     </div> 
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
            </form>
        </div>
      </div>
    </div>


 @include('Admin.Partials.script')
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
       function assignZone(id)
       {
           $('#assignZoneForm').attr('action', '/admin/rider/assignZone/'+id)
       }
       
       function changeActve(id)
       {
            $.ajax({
                url: '/admin/rider/changeStatus/'+id,
                type: 'GET',
                success: function(res) {
                   swal(res.msg,{
                       icon:'success'
                   })
                   window.location.href = "/admin/rider"
                }
            })   
       }
       
    </script>
@endsection
