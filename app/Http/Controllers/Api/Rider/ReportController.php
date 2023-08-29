<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Notification;
use App\Models\Admin;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function getRides($date = NULL)
    {
        $token = request()->bearerToken();
        
        $rider = Rider::where('token', $token)->first();
        
        if($rider)
        {
            $order = [];
            
            if($date == 'today')
            {
                $date = Carbon::today();
                $order = Order::where('rider_id', $rider->id)->where('updated_at', $date)->get();
            }
            else if($date == 'week')
            {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
                $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
                $order = Order::where('rider_id', $rider->id)->whereBetween('updated_at', [$weekStartDate, $weekEndDate])->get();
            }
            else if($date == 'month')
            {
                $order = Order::where('rider_id', $rider->id)
                ->whereBetween('updated_at', [Carbon::now()->subMonth(3), Carbon::now()])->get();
            }
            else if($date == 'year')
            {
                $order = Order::where('rider_id', $rider->id)
                ->whereYear('updated_at', date('Y'))
                ->get();
            }
            else{
                $order = Order::where('rider_id', $rider->id)->get();
            }
            
            return response()->json([
                'status' => true,
                'data' => count($order)
            ]);
            
        }
        
        return response()->json([
            'status' => false,
            'msg' => 'Authentication failed!!'
        ]);
        
    }
    
    public function getEarned($date = NULL)
    {
        $token = request()->bearerToken();
        
        $rider = Rider::where('token', $token)->first();
        
        if($rider)
        {
            $order = [];
            
            if($date == 'today')
            {
                $date = Carbon::today();
                $order = Order::where('rider_id', $rider->id)->where('updated_at', $date)->sum('total_amount');
            }
            else if($date == 'week')
            {
                $now = Carbon::now();
                $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
                $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
                $order = Order::where('rider_id', $rider->id)->whereBetween('updated_at', [$weekStartDate, $weekEndDate])->sum('total_amount');
            }
            else if($date == 'month')
            {
                $order = Order::where('rider_id', $rider->id)
                ->whereBetween('updated_at', [Carbon::now()->subMonth(3), Carbon::now()])->sum('total_amount');
            }
            else if($date == 'year')
            {
                $order = Order::where('rider_id', $rider->id)
                ->whereYear('updated_at', date('Y'))
                ->sum('total_amount');
            }
            else{
                $order = Order::where('rider_id', $rider->id)->sum('total_amount');
            }
            
            
            return response()->json([
                'status' => true,
                'data' => $order
            ]);
            
        }
        
        return response()->json([
            'status' => false,
            'msg' => 'Authentication failed!!'
        ]);
        
    }
    
    public function getGraph($date = NULL)
    {
        $token = request()->bearerToken();
        
        $rider = Rider::where('token', $token)->first();
        
        if($rider)
        {

            $order = Order::where('rider_id', $rider->id)->get();
            
            return response()->json([
                'status' => true,
                'data' => $order
            ]);
            
        }
        
        return response()->json([
            'status' => false,
            'msg' => 'Authentication failed!!'
        ]);
        
    }
}