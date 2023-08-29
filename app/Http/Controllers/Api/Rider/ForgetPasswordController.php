<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordOtp;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{

    public function forgetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $user = Rider::where('email', $request->email)->first();

        if ($user) {

            $otp = mt_rand(000000, 999999);

            $user->otp = $otp;
            $user->save();

            $data = [
                'name' => $user->first_name . ' '. $user->last_name,
                'email' => $user->email,
                'otp' => $otp
            ];

            Mail::to($user->email)->send(new ForgetPasswordOtp($data));

            return response()->json([
                'status' => true,
                'msg' => 'Email has been sent successfully!'
            ]);

        } else {
            return response()->json([
                'status' => true,
                'msg' => 'Account does not exists!',
            ]);
        }

    }

    public function checkOtp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $user = Rider::where('email', $request->email)->first();

        if ($user) {
            if ($user->otp == $request->otp) {
                $user->otp = '';
                $user->save();
                return response()->json([
                    'status' => true,
                    'msg' => 'OTP has been verified!'
                ]);
            }
            return response()->json([
                'status' => false,
                'msg' => 'Wrong OTP! Please try again.'
            ]);
        }
        return response()->json([
            'status' => false,
            'msg' => 'User does not exits!'
        ]);
    }

    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $user = Rider::where('email', $request->email)->first();

        if($user){

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'data' => $user
            ]);

        }
        else{
            return response()->json([
                'status' => false,
                'msg' => 'User not found!'
            ]);
        }


    }

}
