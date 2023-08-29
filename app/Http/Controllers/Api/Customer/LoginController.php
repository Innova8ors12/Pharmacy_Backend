<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Mail\Support;
use App\Models\Contact;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginCustomer(Request $request){

        $validator = Validator::make($request->all(),[
            'email'=> 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ],400);
        }
        else{
            $user = User::where('email', '=', $request->email)->first();
            
            if($user->is_active == 0)
            {
                return response()->json([
                    'status' => false,
                    'error' => 'Account is not active!'
                ],404);
            }
          
            if(!Auth::attempt($request->only('email','password'))){
                return response()->json([
                    'status' => false,
                    'error' => 'The email or password you entered is incorrect'
                ],404);
            }
            // elseif($user->user_type == 1){
            //      return response()->json([
            //         'status' => false,
            //         'error' => 'The email or password you entered is incorrect'
            //     ],404);
            // }
            else{
                $user = Auth::user();
                return response()->json([
                    'status' => TRUE,
                    'message' => 'Login Successfully!',
                   
                    'data' => $user
                ],200);
            }
        }

    }
    
     public function contactSupport(Request $request){
        $contact = new Contact;
        $contact->user_id = $request->user_id;
        $contact->upload_prescriptions_id  = $request->prescription_id;
        $contact->message = $request->message;
        $contact->category = $request->category;
        $contact->save();
        
      if($contact->user_id != ''){
            $name= $contact->user->username;
            $email = $contact->user->email;
            $phone = $contact->user->phone;
            $prescription = $contact->prescription->prescription_name;
            $pharmacy = $contact->prescription->pharmacy->pharmacy_name;
            $message = $request->message;
            $category = $request->category;
        }
        else{
            $name = $contact->prescription->pharmacy->pharmacy_name;
            $email = $contact->prescription->pharmacy->email;
            $phone = $contact->prescription->pharmacy->phone;
            $prescription= $contact->prescription->prescription_name;
            $message = $request->message;
            $category = $request->category;
        }


        $support = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'prescription' => $prescription ,
            'pharmacy' =>  $pharmacy ?? '',
            'category' => $category,
            'message' => $message,
        ];
        
        Mail::to('pharmassist2022@gmail.com')->send(new Support($support));

        return response()->json([
            'status' => true,
            'msg' => 'Your request has been recieved'
        ]);
    }
    
    public function deleteUser()
    {
        
        $access_token = request()->bearerToken();
        
        $user = User::where('access_token', '=', $access_token)->first();
        
        if (!empty($user)) {
        
           if($user->is_active == 1)
           {
               $user->is_active = 0;
               $user->save();
           }
           else{
            
                $user->is_active = 1;
                $user->save();
               
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
    
    public function updateLatLong(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'type'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ],400);
        }
        
        
        $access_token = request()->bearerToken();
    
        $user = null;
        
        if($request->type == 1)
        {
            $user = User::where('access_token', '=', $access_token)->first();
        }
        else if($request->type == 2)
        {
            $user = Pharmacy::where('access_token', '=', $access_token)->first();
        }
        else
        {
            $user = Rider::where('token', '=', $access_token)->first();
        }
        
        if (!empty($user)) {
        
           $user->latitude = $request->latitude;
           $user->longitude = $request->longitude;
           
           $user->save();
           
           return response()->json([
                'status' => true,
                'data' => 'Updated Successfully!'
            ], 200);
           
        } else {
            return response()->json([
                'status' => false,
                'data' => 'authenticated'
            ], 401);
        }
        
    }
    
}
