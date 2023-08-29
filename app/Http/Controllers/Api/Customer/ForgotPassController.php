<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\PseudoTypes\True_;

class ForgotPassController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        $user = User::where('email', '=', $request->email)->first();
        $pharmacy = Pharmacy::where('email','=',$request->email)->first();
        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'error' => $validator->errors()
            ],400);
        } else {
            if ($user && $request->user_type == 1) {
                $otp = rand(1000, 9999);

                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => $otp,
                    'created_at' => Carbon::now()
                ]);

                $email = [
                    'title' => 'Reset Password OTP',
                    'body' => 'Your OTP Is ' . $otp
                ];

                Mail::to($user->email)->send(new ForgotPassword($email));

                return response()->json([
                    'status' => True,
                    'msg' => 'OTP is send to your email',
                    'otp' => $otp
                ],200);
            } 
            elseif($pharmacy && $request->user_type == 2){
                   $otp = rand(1000, 9999);

                DB::table('password_resets')->insert([
                    'email' => $pharmacy->email,
                    'token' => $otp,
                    'created_at' => Carbon::now()
                ]);

                $email = [
                    'title' => 'Reset Password OTP',
                    'body' => 'Your OTP Is ' . $otp
                ];

                Mail::to($pharmacy->email)->send(new ForgotPassword($email));

                return response()->json([
                    'status' => True,
                    'msg' => 'OTP is send to your email',
                    'otp' => $otp
                ],200);
            }
            else {
                return response()->json([
                    'status' => FALSE,
                  
                    'msg' => 'Email does not exist !!!'
                ],404);
            }
        }
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
           // 'email' => 'required|email',
            'otp' => 'required|min:4|max:4',
            //'new_pass' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => FALSE,
                'error' => $validator->errors()
            ],400);
        } else {
            $reset = DB::table('password_resets')
                ->where('token', '=', $request->otp)
                ->first();

            if (!$reset) {
                return response()->json([
                    'status' => FALSE,
                    'msg' => 'Verification Code is not valid',
                   
                ],404);
            } else {
                return response()->json([
                    'status' => True,
                    'msg' => 'OTP verified',
                ],200);
            }
        }
    }
    
    public function changePassword(Request $request){
        $newpass = Hash::make($request->new_pass);

        $pharmacy = Pharmacy::where('email', '=', $request->email)->first();
        $user= User::where('email', '=', $request->email)->first();
        if($pharmacy || $user){
            if ($request->user_type== 2) {
                $passwordpharmacy = Pharmacy::where('email', '=', $request->email)->update([
                    'password' => Hash::make($request->new_pass)
                ]);
                  DB::table('password_resets')->where(['email' => $request->email])->delete();
            } else {
                $passwordcustomer = User::where('email', '=', $request->email)->update([
                    'password' => Hash::make($request->new_pass)
                ]);
                  DB::table('password_resets')->where(['email' => $request->email])->delete();
            }
             return response()->json([
                'status' => TRUE,
                'msg' => 'password updated',
            ], 200);
        }
        else{
            return response()->json([
                'status' => TRUE,
                'msg' => '',
            ], 404);
        }


      

    }
    
    
}
