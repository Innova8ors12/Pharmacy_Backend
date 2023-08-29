@extends('Admin.Layouts.master')
@section('content')
    <div class="page-title d-flex align-items-center justify-content-between flex-wrap">
        <h2>Transactions</h2>
    </div>
    <div class="cover-inner-content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-start justify-content-between border-bottom pb-3 mb-3">
                            <div>
                                <p class="m-0">{{ $record->pharmacy->pharmacy_name }}</p>
                                <p class="m-0">{{ $record->pharmacy->location }}</p>
                                <p class="m-0">{{ $record->pharmacy->phone }}</p>
                            </div>
                            <div>
                                <p class="m-0"><span class="font-weight-600 text-black">Withdrawal Date:</span>
                                    {{ $record->created_at->format('F d,Y') }}</p>
                                <p class="m-0"><span class="font-weight-600 text-black">Withdrawal Amount:</span>
                                    {{ $record->amount }}$</p>
                            </div>
                        </div>
                        <div class="cover-order-table">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>ITEM</th>
                                        <th>AMOUNT</th>
                                        <th>SERVICE FEE</th>
                                        <th>VAT FEE</th>
                                        <th>DISCOUNT</th>
                                        <th>Withdrawal Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $prescription = [];
                                    $total = 0;
                                    $i = 0;
                                    @endphp
                                    
                                    @foreach ($record->withdrawalrecord as $items)
                                    
                                    @php
                                     array_push($prescription,$items->upload_prescription_id);
                                    $total += $items->prescription->order->total_amount - $items->prescription->order->service_fee;
                                     $i += 1;
                                    @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $items->prescription->prescription_name }}</td>
                                           <td>{{$items->prescription->order->total_amount}}$</td>
                                            <td>{{$items->prescription->order->service_fee}}$</td>
                                             <td>{{$items->prescription->order->vat_price}}$</td>
                                              <td>{{$items->prescription->order->insurance_discount}}$</td>
                                            <td>
                                          {{$items->prescription->order->total_amount - ($items->prescription->order->service_fee)}}$
                                            </td>
                                            
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
                            </div>
                           
                        </div>
                        <form id="approveForm">
                            <input type="hidden" value="{{csrf_token()}}" name="_token">
                            <input type="hidden" value="{{ $record->id}}" name="withdrawal_id">
                            @foreach($prescription as $disease)
                            <input type="hidden" value="{{ $disease }}" name="prescription_id[]">
                            @endforeach
                            
                             <input type="hidden" value="{{ $record->kano_email}}" name="kano_email">
                             <input type="hidden" value="{{$total}}" name="amount">
                             <button type="submit" class="btn btn-primary" id="approveBtn">Approve</button>
                        </form>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Admin.Partials.script')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    <script>
    $('#approveForm').on('submit', function(e) {
    e.preventDefault();
    $('#approveBtn').empty().append('Please Wait..')
    $('#approveBtn').css({
        'cursor': 'not-allowed',
    })
    $('#approveBtn').attr('disabled', true)
    var formdata = new FormData(this);
    $.ajax({
        url: '{{route("admin.withdrawal.approve")}}',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formdata,
        success: function(res) {
            if(res.status == true){
            $('#approveBtn').empty().append('Approve')
            $('#approveBtn').css({
                'cursor': 'pointer',
            })
            $('#approveBtn').attr('disabled', false)
            swal(res.msg,{
                icon:'success'
            }).then(()=> {
                window.location.reload()
            })
            console.log(res) 
            }
            else{
               $('#approveBtn').empty().append('Approve')
            $('#approveBtn').css({
                'cursor': 'pointer',
            })
            $('#approveBtn').attr('disabled', false)
            swal(res.msg,{
                icon:'error'
            }).then(()=> {
                window.location.reload()
            })
            console.log(res)  
            }
          
        }
    })
})
    </script>
@endsection
