<?php

namespace App\Http\Controllers\Api\Pharmassist;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\Zone;
use App\Mail\AccountRequest;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function createPharmacy(Request $request)
    {
         $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        $validator= Validator::make($request->all(),[
            'pharmacy_name' => 'required',
            'email' => 'required|unique:pharmacies,email,$this->id,id',
            'password' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'zone' => 'required',
            'merchant_id' => 'nullable',
            'authorize_key' => 'nullable',
        ],
         [
        'email.unique' => 'This email address is already in use',
    ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'code' => 500,
                'error' => $validator->errors()->first()
            ]);
        }
        else{
            $zone = Zone::where('name', $request->zone)->first();
            if(!$zone)
            {
                return response()->json([
                'status' => false,
                'code' => 500,
                'error' => 'Zone not found!!'
            ]);
            }
            $token=Str::random(40);
            $pharmacy= new Pharmacy;
            $pharmacy->pharmacy_name = $request->pharmacy_name;
            $pharmacy->email = $request->email;
            $pharmacy->kano_email = 'null';
            $pharmacy->password = Hash::make($request->password);
            $pharmacy->phone = $request->phone;
            $pharmacy->contact_person = $request->contact_person;
             $pharmacy->country = $request->country;
            $pharmacy->location = $request->location;
                  $pharmacy->access_token =$token ;
                   $pharmacy->fcm_token  =$request->fcm_token;
            if($request->file('pharmacy_image')){
                $file = $request->file('pharmacy_image');
                $filename = $file->getClientOriginalName();
                $move = $file->move('storage/pharmacy/',$filename);
                $host = $request->getSchemeAndHttpHost();
                $imageurl = $host.'/'.$move;
                $pharmacy->image = $imageurl;
            }
            
            
            $pharmacy->zone_id = $zone->id;
            $pharmacy->merchant_id = $request->merchant_id;
            $pharmacy->authorize_key = $request->authorize_key;
            $pharmacy->save();
            
               $accrequest = [
                'title' => 'Hello,',
                'msg' => 'Thank you for your interest in The Pharmassist. Kindly note that your account request is currently under review. Please allow up to 2 business days for approval.'
            ];
            Mail::to($request->email)->send(new AccountRequest($accrequest));
            
            $admin = new AdminNotification;
            $admin->pharmacy_name = $request->pharmacy_name;
            $admin->title = 'Pharmacy Signup';
            $admin->is_seen = 0;
            $admin->created_at = $newDateTime;
            $admin->updated_at = $newDateTime;
            $admin->save();
        
            return response()->json([
                'status' => true,
                'msg' => 'Pharmacy Registered successfully!',
                'data' => $pharmacy
            ],200);
        }

    }
    
     public function updatePharmacy(Request $request)
    {
        $pharmacy= Pharmacy::find($request->pharmacy_id);
        $pharmacy->pharmacy_name = $request->pharmacy_name ??  $pharmacy->pharmacy_name;
        $pharmacy->contact_person = $request->contact_person ?? $pharmacy->contact_person ;
        $pharmacy->country = $request->country ?? $pharmacy->country;
        $pharmacy->kano_email = $request->kano_email ?? $pharmacy->kano_email;
        $pharmacy->email = $request->email ??  $pharmacy->email;
        $pharmacy->fcm_token  =$request->fcm_token ?? $pharmacy->fcm_token;
        $pharmacy->phone = $request->phone ??  $pharmacy->phone;
        $pharmacy->location = $request->location ??  $pharmacy->location;
        if ($request->file('pharmacy_image')) {
            $file = $request->file('pharmacy_image');
            $filename = time().'.'.$file->getClientOriginalName();
            $move = $file->move('storage/pharmacy/',$filename);
            $host = $request->getSchemeAndHttpHost();
            $imageurl = $host.'/'.$move;
            $pharmacy->image = $imageurl ??  $pharmacy->image;
        }
        $pharmacy->save();

        return response()->json([
            'status' => true,
            'msg' => 'Profile updated successfully!',
            'data' => $pharmacy
        ],200);
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
    
}
