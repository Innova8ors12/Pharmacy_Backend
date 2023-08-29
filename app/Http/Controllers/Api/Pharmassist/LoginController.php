<?php

namespace App\Http\Controllers\Api\Pharmassist;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\WithdrawlRecord;
use App\Models\WithdrawlRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginPharmacy(Request $request)
    {
            $validator = Validator::make($request->all(),[
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validator->fails()){
            return response()->json([
                'status' => false,
                
                'error' => $validator->errors()
            ],400);
            }
            else{
        $loginHash = Pharmacy::where('email','=',$request->email)->first();
                $login= Pharmacy::where('email','=',$request->email)->count();
                if($login == 0){
                return response()->json([
                    'status' => false,
                   
                    'error' => 'The email or password you entered is incorrect'
                ],404);
                }
                elseif(!Hash::check($request->password, $loginHash->password ?? '')){
                return response()->json([
                    'status' => false,
                  
                    'error' => 'The email or password you entered is incorrect'
                ],404);
                }
                  elseif($loginHash->is_active == 0){
                return response()->json([
                    'status' => false,
                    'error' => 'Account Request is pending, please await approval'
                ], 404);
            }
                else{
                   
                return response()->json([
                    'status' => TRUE,
                    'message' => 'Login Successfully!',
                
                    'data' => $loginHash
                ],200);
                }
            }
    }
    
      public function getPharmacyTransaction()
    {
        $access_token = request()->bearerToken();
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        if (!empty($pharmacy)) {
            $order = Order::with('prescription')
                ->where('pharmacy_id', '=', $pharmacy->id)
                ->where('delivery_status', '=', 'Delivered')
                ->orderBy('created_at', 'DESC')->get();

            if (!$order->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'data' => $order
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'data' => $order
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
    }
    
     public function withdrawalRequest(Request $request)
    {
        $access_token = request()->bearerToken();
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        if (!empty($pharmacy)) {
            
            $withdraw = new WithdrawlRequest;
            $withdraw->pharmacy_id = $pharmacy->id;
            $withdraw->amount = $request->amount;
            $withdraw->kano_email = $request->kano_email;
            $withdraw->status = 'Pending';
            $withdraw->save();
            
             if ($request->prescription_id) {
                foreach ($request->prescription_id as $key => $value) {
                    WithdrawlRecord::create([
                        'withdrawl_request_id' => $withdraw->id,
                        'upload_prescription_id' => $request->prescription_id[$key]
                    ]);
                    
                      $update = Order::whereIn('upload_prescription_id',array($request->prescription_id[$key]))->update([
                'withdrawal_status' => 'Pending'
                ]);
                }
            }
            
          

            return response()->json([
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
    }
    
    public function getWithdrawalRequest(Request $request)
    {
        $access_token = request()->bearerToken();
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        if (!empty($pharmacy)) {
            $withdraw =WithdrawlRequest::orderBy('id','DESC')->get();
            if(!$withdraw->isEmpty()){
                return response()->json([
                     'data' => $withdraw,
                'status' => true,
            ], 200);  
            }
            else{
                return response()->json([
                'status' => false,
            ], 200); 
            }
           
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
    }
    
    public function updateKeys(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'merchant_id' => 'nullable',
            'authorize_key' => 'nullable'
        ]);
        
        if($validator->fails()){
        
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ],400);
        }
        
        $access_token = request()->bearerToken();
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        
        if (!empty($pharmacy)) {
        
           $pharmacy->merchant_id = isset($request->merchant_id) ? $request->merchant_id : $pharmacy->merchant_id;
           $pharmacy->authorize_key = isset($request->authorize_key) ? $request->authorize_key : $pharmacy->authorize_key;
           
           $pharmacy->save();
           
           $pharmacy = Pharmacy::where('id' , $pharmacy->id)->first();
           
           return response()->json([
                'status' => true,
                'data' => $pharmacy
            ], 200);
           
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
        
    }
    
    public function deletePharmacy()
    {
        
        $access_token = request()->bearerToken();
        
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        
        if (!empty($pharmacy)) {
        
           if($pharmacy->is_active == 1)
           {
               $pharmacy->is_active = 0;
               $pharmacy->save();
           }
           else{
            
                $pharmacy->is_active = 1;
                $pharmacy->save();
               
           }
           
           return response()->json([
                'status' => true,
                'data' => 'Deactivated Successfully!'
            ], 200);
           
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
        
    }
    
}
