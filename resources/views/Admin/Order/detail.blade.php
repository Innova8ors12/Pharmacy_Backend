@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Order details</h2>
    </div>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between border-bottom pb-3 mb-3">
                            <div>
                                <h2 class="font-weight-600">{{ $details->user->username }}</h2>
                                <h6 class="mb-1 font-weight-600">{{ $details->user->country }}</h6>
                                <h6 class="m-0 font-weight-600"> {{ $details->user->phone }}</h6>
                            </div>
                            <ul>
                                <li><button onclick="window.print();" class="primary-btn extra-btn-padding-30"
                                        style="background: #0000FE;">Print</button></li>
                            </ul>
                        </div>
                           
                                @if($details->payment_status == 'SUCCESS')
                               <span  class="badge rounded-pill bg-success">PAID</span>
                                 @else
                               <span class="badge rounded-pill bg-danger">UNPAID</span>
                                @endif
                               
                               
                        <div class="d-flex align-items-start justify-content-between border-bottom pb-3 mb-3">
                            <div>
                                <p class="m-0">{{ $details->pharmacy->pharmacy_name }}</p>
                                <p class="m-0">{{ $details->pharmacy->location }}</p>
                                <p class="m-0">{{ $details->pharmacy->phone }}</p>
                            </div>
                            <div>
                                <p class="m-0"><span class="font-weight-600 text-black">Order Date:</span>
                                    {{ $details->created_at->format('F d,Y') }}</p>
                                <p class="m-0"><span class="font-weight-600 text-black">Order Status:</span>
                                    {{ $details->delivery_status }}</p>
                                <p class="m-0"><span class="font-weight-600 text-black">Order ID:</span>
                                    #{{ $details->id }}
                                </p>
                            </div>
                        </div>
                        <div class="cover-order-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>PRICE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                        $i = 1;
                                    @endphp
                                    @foreach ($details->orderitem as $items)
                                   
                                      <tr>
                                            @php
                                                $total += ($items->price);
                                                Session::put('total".."',$total);
                                                $i += 1;
                                            @endphp
                                            <td>{{ $i }}</td>
                                             @if($items->removed_by_user == "1")
                                              <td><del>{{ $items->item_name }}</del></td>
                                             @else
                                              <td>{{ $items->item_name }}</td>
                                            @endif
                                          
                                            <td>{{ $items->quantity }}</td>
                                             @if($items->removed_by_user == "1")
                                              <td><del>${{ number_format($items->price) }}</del></td>
                                             @else
                                              <td>${{ number_format($items->price) }}</td>
                                            @endif
                                           
                                        </tr>  
                                   
                                     
                                     
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-end flex-column justify-content-end">
                            <div class="my-3">
                                <p class="m-0"><span class="font-weight-600 text-black">Sub-total:</span>
                                    {{ number_format($total) }}$
                                </p>
                                @if($details->insurance_discount != 0)
                                 <p class="m-0"><span class="font-weight-440 text-black">Discount:</span>
                                    {{ number_format($details->insurance_discount) }}$
                                </p>
                                 <p class="m-0"><span class="font-weight-600 text-black">Discounted Total:</span>
                                    {{ number_format($total - $details->insurance_discount) }}$
                                </p>
                                @endif
                                   <p class="m-0"><span class="font-weight-440 text-black">Service Fee:</span>
                                    {{ number_format($details->service_fee) }}$
                                </p>
                                <p class="m-0"><span class="font-weight-440 text-black">Vat:</span>
                                    {{ number_format($details->vat_price) }}$
                                </p>
                              
                            </div>
                             @if($details->insurance_discount != 0)
                                 <h1 class="font-weight-600">USD {{ number_format( ($total + $details->service_fee + $details->vat_price) - $details->insurance_discount ) }}$</h1>
                                 @else
                                    <h1 class="font-weight-600">USD {{ number_format($total + $details->service_fee + $details->vat_price ) }}$</h1>
                                @endif
                           
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
