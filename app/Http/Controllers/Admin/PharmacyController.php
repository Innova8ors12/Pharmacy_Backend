<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountApprove;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PharmacyController extends Controller
{
    public function index(){
        $pharmacy = Pharmacy::all();
        return view('Admin.Pharmacy.index',compact('pharmacy'));
    }
    
    public function accountApprove(Request $request)
    {
        $pharmacy = Pharmacy::where('id','=',$request->id)->first();
        
        if($pharmacy->is_active == 0){
            $update = Pharmacy::where('id', '=', $request->id)->update([
            'is_active' => 1
        ]);

        $approve = [
            'title' => 'Hello,',
            'msg' => 'Your new account request was reviewed and processed. Please feel free to sign in on the application. Thank you. '
        ];

        Mail::to($request->email)->send(new AccountApprove($approve));

        return response()->json([
            'status' => true,
            'msg' => 'Account Approved',
        ], 200); 
        }
        else{
             $update = Pharmacy::where('id', '=', $request->id)->update([
            'is_active' => 0
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Account Deactive',
        ], 200);
        }
       
    }
    
    public function delete($id)
    {
        $pharmacy= Pharmacy::where('id', $id)->first();
        
        if($pharmacy)
        {
            $pharmacy->delete();
            
        }
        
        
        return redirect()->back();
        
        
    }
    
    public function changeZone(Request $request, $id)
    {
        $pharmacy= Pharmacy::where('id', $id)->first();
        
        if($pharmacy)
        {
            $pharmacy->zone_id = $request->zone_id;
            $pharmacy->save();
        }
        
        
        return redirect()->back();
        
        
    }
    
    public function orderAllowed(Request $request, $id)
    {
        $pharmacy= Pharmacy::where('id', $id)->first();
        
        if($pharmacy)
        {
            $pharmacy->order_per_day = $request->order_per_day;
            $pharmacy->order_per_week = $request->order_per_week;
            $pharmacy->order_per_month = $request->order_per_month;
            $pharmacy->save();
        }
        
        
        return redirect()->back();
        
        
    }
    
}
