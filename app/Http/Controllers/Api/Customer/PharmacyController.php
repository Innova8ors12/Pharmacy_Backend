<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\User;

class PharmacyController extends Controller
{
    public function getPharmacy(){
        $pharmacy = Pharmacy::where('is_active','=',1)->get();
        return response()->json([
            'status' => TRUE,
            'data' => $pharmacy,
            'code' => 200
        ]);
    }
    
    public function getSingleCustomer(Request $request){
        $access_token= request()->bearerToken();
        $customer = User::where('access_token','=', $access_token)->first();
         if($customer){
              return response()->json([
            'status' => TRUE,
            'data' => $customer,
            
        ],200);
        }else{
            return response()->json([
            'status' => FALSE,
            'data' => '',
        ],400); 
        }
    }
}

