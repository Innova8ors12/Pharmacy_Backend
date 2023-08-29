@extends('Admin.Layouts.master')
@section('content')

    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Pharmacies</h2>
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
                        <h4 class="card-title d-flex align-itesms-center justify-content-between">Pharmacies <i
                                class="bi bi-info-circle"></i></h4>
                        <div class="cover-datatable" style="overflow:auto ">
                            <table class="table align-middle" id="userdatatable">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Country</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Orders fulfilled</th>
                                        <th>Zone</th>
                                        <th>Order Per Day</th>
                                        <th>Order Per Week</th>
                                        <th>Order Per Month</th>
                                        <th>Account Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                  <tbody>
                                        @foreach ($pharmacy as $pharma)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2 ps-4">
                                                        <div class="green-dot green-dot-none">
                                                            <img src="{{ asset($pharma->image) }}"
                                                                class="border-radius-50px" alt=""
                                                                style="width: 45px; height: 45px; object-fit: cover">
                                                        </div>
                                                        <p class="m-0 font-weight-600 text-black">
                                                            {{ $pharma->pharmacy_name }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                       
                                                        {{ $pharma->location }}
                                                    </div>
                                                </td>
                                                <td>
                                                  {{ $pharma->email }}
                                                </td>
                                                <td>{{ $pharma->phone }}</td>
                                                @php
                                                $fullfilled =  App\Models\UploadPrescription::where('pharmacy_id','=',$pharma->id)->where('status','=','Delivered')->count();
                                                @endphp
                                                <td>
                                                    {{$fullfilled}}
                                                </td>
                                                <td>
                                                    {{ $pharma->zone->name }}
                                                </td>
                                                <td>
                                                    {{$pharma->order_per_day}}
                                                </td>
                                                <td>
                                                    {{$pharma->order_per_week}}
                                                </td>
                                                <td>
                                                    {{$pharma->order_per_month}}
                                                </td>
                                               <td>
                                                    <div class="form-check form-switch">
                                                         <input class="form-check-input toggle" type="checkbox" data-id="{{$pharma->id}}" data-email="{{$pharma->email}}"  role="switch" id="flexSwitchCheckDefault" {{$pharma->is_active == 1 ? 'checked' : ''}}>
                                                    </div>
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
                                                                    <a href="#." onclick="changeZone({{ $pharma->id }})"
                                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                        class="dropdown-item text-primary">Change Zone</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#." onclick="allowOrder({{ $pharma->id }})"
                                                                    data-bs-toggle="modal" data-bs-target="#orderAllowedModal"
                                                                        class="dropdown-item text-primary">Allow/Indicate Order</a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('admin.pharmacy.delete', ['id' => $pharma->id]) }}"
                                                                        class="dropdown-item text-danger">Delete</a>
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
            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Zone</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="changeZoneForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="zone_id">
                            <option>Select Zone</option>
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
    
    <div class="modal fade" id="orderAllowedModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Order Allowed</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <form id="allowOrderForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Order Per Day:</label>
                        <input class="form-control" name="order_per_day" required>
                     </div> 
                     <div class="form-group">
                        <label>Order Per Week:</label>
                        <input class="form-control" name="order_per_week" required>
                     </div> 
                     <div class="form-group">
                        <label>Order Per Month:</label>
                        <input class="form-control" name="order_per_month" required>
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
    function changeZone(id)
    {
        $('#changeZoneForm').attr('action', '/admin/pharmacy/changeZone/'+id)
    }
    
    function allowOrder(id)
    {
        $('#allowOrderForm').attr('action', '/admin/pharmacy/orderAllowed/'+id)
    }
       
        $('.toggle').on('change', function() {
            var id = $(this).attr('data-id');
            var email = $(this).attr('data-email');
            $.ajax({
                url: '{{ route('admin.pharmacy.account') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'email': email,
                },
                success: function(res) {
                   swal(res.msg,{
                       icon:'success'
                   })
                }
            })
        })
    </script>
@endsection
