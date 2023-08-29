<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function appNotifications(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors(),
            ], 400);

        } else {

            $notification = new Notification;
            $notification->noti_from = $request->noti_from;
            $notification->noti_to = $request->noti_to;
            $notification->upload_prescription_id = $request->upload_prescription_id;
            $notification->title = $request->title;
            $notification->body = $request->body;
            $notification->is_read = 0;
            $notification->save();

            return response()->json([
                'status' => true,
            ], 200);
        }
    }

    public function readNotification($id){
        $notification = Notification::where('id','=',$id)->update([
            'is_read' => 1
        ]);
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function getNotificationCustomer(){

        $access_token= request()->bearerToken();
        if(!empty($access_token)){
            $user = User::where('access_token', '=', $access_token)->first();
               $notification = Notification::with('prescription.user','prescription.pharmacy','prescription.statuslog','prescription.prescriptionpricing.pricingitem')->where('noti_to', '=', $user->id)->orderBy('id','DESC')->get();
            if(!empty($notification)){
             
                return response()->json([
                    'status' => true,
                    'data' => $notification
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'data' => '',
                ], 404);
            }
        }
        else{
            return response()->json([
                'status' => false,
                'msg' => 'unauthenticated',
            ], 401);
        }
    }

    public function getNotificationPharmacy()
    {
        $access_token = request()->bearerToken();
      
            $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
            if(!empty($pharmacy)){
                $notification = Notification::with('prescription.user','prescription.pharmacy','prescription.statuslog','prescription.prescriptionpricing.pricingitem')->where('noti_to', '=', $pharmacy->id)->orderBy('id','DESC')->get();
                if($notification){
                     return response()->json([
                    'status' => true,
                    'data' => $notification
                ], 200); 
                }
                else{
                    return response()->json([
                    'status' => false,
                    'data' => '',
                ], 404); 
                }
              
            }
            else{
                 return response()->json([
                'status' => false,
                'msg' => 'unauthenticated',
            ], 401);
            }
    }
    
     public function getNotificationRider(){

        $access_token= request()->bearerToken();
        
        if(!empty($access_token)){
        
            $user = Rider::where('token', '=', $access_token)->first();
            
            $notification = Notification::where('rider_id', '=', $user->id)->orderBy('id','DESC')->get();

            if(!empty($notification)){
             
                return response()->json([
                    'status' => true,
                    'data' => $notification
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'data' => '',
                ], 404);
            }
        }
        else{
            return response()->json([
                'status' => false,
                'msg' => 'unauthenticated',
            ], 401);
        }
    }
    
}
