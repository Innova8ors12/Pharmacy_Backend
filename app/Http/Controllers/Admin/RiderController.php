<?php

namespace App\Http\Controllers\Admin;
use App\Models\Rider;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function index(){
        
        $riders = Rider::all();
         
        return view('Admin.Rider.index',compact('riders'));
    }
    
    public function changeStatus($id)
    {
        
        $rider = Rider::where('id', $id)->first();
        
        $status = '';
        
        if($rider->is_active == 0)
        {
            $rider->is_active = 1;
            $status = 'approved!';
        }
        else if($rider->is_active == 1)
        {
            $rider->is_active = 0;
        
            $status = 'disabled!';
            
        }
        
        $rider->save();
        
        return response()->json([
            'status' => true,
            'msg' => 'Account has been '. $status .'!!'
        ]);
        
    }
    
    public function privacy(){
        
        return view('Admin.Rider.privacy');
    }
    public function terms(){
        
        return view('Admin.Rider.terms');
    }
    
    public function report($id)
    {   
        $orders = [];
        
        $dynamicChartData = [];
        
         $orders = Order::where('rider_id', $id)
            ->select('created_at', 'total_amount')
            ->orderBy('created_at')
            ->get();

            foreach ($orders as $order) {
                // Format the timestamp and revenue values as needed
                $timestamp = strtotime($order->created_at) * 1000; // Convert to milliseconds
                $revenue = $order->total_amount;
                
                $dynamicChartData[] = [$timestamp, $revenue];
            }
        // dd($dynamicChartData);
        return view('Admin.Rider.report', get_defined_vars());
    }
    
    public function track($id)
    {   
         $userslatlong = Rider::where('id', $id)->where('longitude', '!=', NULL)
        ->where('latitude', '!=', NULL)->get();
        // dd($dynamicChartData);
        return view('Admin.Rider.track', get_defined_vars());
    }
    
}
