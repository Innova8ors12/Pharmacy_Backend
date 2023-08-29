<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\UploadPrescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\StatusLog;

class OrderController extends Controller
{

    public function getAll()
    {
        $token = request()->bearerToken();
        
        $rider = Rider::where('token', $token)->first();
        
        if($rider)
        {
            if($rider->zone_id != null)
            {
                $zoneId = $rider->zone_id;
                $order = Order::with('pharmacy', 'user', 'orderitem')
                ->whereHas('pharmacy', function($q) use ($zoneId) {
                    $q->where('zone_id', $zoneId);
                })
                ->where('delivery_status', '!=', 'Delivered')
                ->where('delivery_status', '!=', 'Declined')
                ->where('delivery_status', '!=', 'Cancelled')
                ->where('delivery_status', '!=', 'Out For Delivery')
                ->where('delivery_status', '!=', 'Marked as Delivered')
                ->where('delivery_status', '!=', 'Marked as Collected')
                ->where('delivery_status', '!=', 'Accept')
                ->get();
        
                return response()->json([
                    'status' => true,
                    'order' => $order
                ]);
            }
            else{
                return response()->json([
                    'status' => true,
                    'order' => []
                ]);
            }
            
        }
        else{
            return response()->json([
                'status' => false,
                'msg' => 'Invalid Token!!'
            ]);
        }
        
    }

    public function order_status(Request $request)
    {
        $token = request()->bearerToken();

        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        
        $rider = Rider::where('token', $token)->first();

        $validator = Validator::make($request->all(),[
            'order_id' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }
        

        if($rider)
        {
            $order = Order::where('id', $request->order_id)
            ->with('pharmacy', 'user', 'orderitem')
            ->first();
            if($order)
            {
                
                $order->rider_id = $rider->id;
                $order->delivery_status = $request->status;
    
                $order->save();
                $checkPresciption = UploadPrescription::where('rider_id', $rider->id)->first();
                
                $presciption = UploadPrescription::where('id', $order->upload_prescription_id)->first();

                $presciption->rider_id = $rider->id;
                $presciption->status = $request->status;
                $presciption->save();
                    
                
                $status= new StatusLog;
                $status->upload_prescription_id = $presciption->id;
                $status->status = $request->status;
                $status->created_at = $newDateTime;
                $status->updated_at = $newDateTime;
                $status->save();
                
                
                $admin = Admin::first();
                
                Notification::create([
                    'rider_id' => $rider->id,
                    'title' => 'Order has been ' . $request->status,
                    'body' => 'Order has been ' . $request->status,
                    'is_read' => 0
                ]);
    
                return response()->json([
                    'status' => true,
                    'data' => $order
                ]);
                
            }
            else{
                return response()->json([
                    'status' => false,
                    'msg' => 'Order not found!!'
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'msg' => 'Invalid Token!!'
        ]);

    }

    public function orderHistory()
    {
        $token = request()->bearerToken();

        $rider = Rider::where('token', $token)->first();

        if ($rider) {
            $order = Order::with('pharmacy', 'user', 'orderitem')
            ->where('rider_id', $rider->id)->get();

            return response()->json([
                'status' => true,
                'data' => $order
            ]);
        }

        return response()->json([
            'status' => false,
            'msg' => 'Invalid Token!!'
        ]);
    }
}
