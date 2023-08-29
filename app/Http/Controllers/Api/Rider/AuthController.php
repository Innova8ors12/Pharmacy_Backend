<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use App\Mail\SignUpOtp;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'email' => 'required|email|unique:riders,email',
          
        ]);
        if ($validator->fails()) {
            
            return response()->json([
                'status' => false,
                'msg' =>  $validator->errors()->first()
            ]);
            
        } else {
           
            DB::table('password_resets')->where('email', '=', $request->email)
            ->delete();
        
            $otp = rand(111111, 999999);

                
            $data = [
                'name' => $request->first_name .  ' ' . $request->last_name,
                'otp' => $otp
            ];

            Mail::to($request->email)->send(new SignUpOtp($data));
                
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $otp
            ]);

            return response()->json([
                'status' => true,
                 'otp' => $otp
            ], 200);
        }
    }
    
    public function CheckOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric',
          
        ]);
        if ($validator->fails()) {
            
            return response()->json([
                'status' => false,
                'msg' =>  $validator->errors()->first()
            ]);
            
        } else {
           
            $check = DB::table('password_resets')->where([
                'email' => $request->email,
            ])->first();
            

            if($check)
            {
                if($check->token == $request->otp)
                {
                    return response()->json([
                        'status' => true,
                        'otp' => 'Otp matched!'
                    ], 200);
                }
                else{
                    
                    return response()->json([
                        'status' => false,
                        'check' => $check->token,
                        'otp' => 'Otp not matched!'
                    ]);
                    
                }
            }


            return response()->json([
                'status' => false,
                 'msg' => 'Invalid Email'
            ]);
        }
    }
    
    public function resendOtp(Request $request){
        DB::table('password_resets')->where('email', '=', $request->email)
        ->delete();
        
        $otp = rand(111111, 999999);

        $data = [
            'otp' => $otp,
        ];
                
                
        $data = [
            'name' => $request->first_name .  ' ' . $request->last_name,
            'otp' => $otp
        ];
        
        Mail::to($request->email)->send(new SignUpOtp($data));
                
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $otp
            ]);

            return response()->json([
                'status' => true,
                 'otp' => $otp
            ], 200);
    }

    
    public function register(Request $request)
    {

        // return response()->json([
        //     'status' => true,
        //     'data' => $request->all(),
        // ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:riders,email',
            'phone' => 'required',
            'address' => 'required',
            'house_no' => 'required',
            'password' => 'required',
            'island' => 'required',
            'vehicle_type' => 'required',
            'vehicle_model' => 'required',
            'vehicle_color' => 'required',
            'number_plate' => 'required',
            'year_of_vehicle' => 'required',
            'lisence' => 'required',
            'license_no' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $rider = new Rider();

        $rider->first_name = $request->first_name;
        $rider->last_name = $request->last_name;
        $rider->email = $request->email;
        $rider->phone = $request->phone;
        $rider->address = $request->address;
        $rider->house_no = $request->house_no;
        $rider->password = Hash::make($request->password);
        $rider->island = $request->island;
        $rider->vehicle_type = $request->vehicle_type;
        $rider->vehicle_model = $request->vehicle_model;
        $rider->color = $request->vehicle_color;
        $rider->number_plate = $request->number_plate;
        $rider->year_of_vehicle = $request->year_of_vehicle;
        $rider->longitude = $request->longitude;
        $rider->latitude = $request->latitude;
        $rider->license_no = $request->license_no;
        
        $otp = mt_rand(111111, 999999);

        if ($request->hasFile('lisence')) {

            $host = request()->getSchemeAndHttpHost();
            $file = $request->file('lisence');
            $filename = $host . '/storage/user/lisence/' . time() . '-'. $file->getClientOriginalName();
            $move = $file->move('storage/user/lisence/', $filename);
            $url = $host . '/' . $move;
            $rider->lisence = $filename;

        }
        
        $rider->save();

        $token = $rider->createToken('API TOKEN')->plainTextToken;

        $rider = Rider::where('id', $rider->id)->with('zone')->first();
        $rider->token = $token;
        $rider->save();

        // $data = [
        //     'name' => $request->first_name .  ' ' . $request->last_name,
        //     'otp' => mt_rand(000000, 999999)
        // ];

        // Mail::to($request->email)->send(new SignUpOtp($data));

        if ($rider) {
            return response()->json([
                'status' => true,
                'data' => $rider,
            ]);
        }

        return response()->json([
            'status' => false,
            'msg' => 'Something went wrong!',
        ]);
    }

    public function login(Request $request)
    {
        // return response()->json([
        //     'status' => true,
        //     'data' => $request->all(),
        // ]);

        $check = Rider::where('email', $request->email)->with('zone')->first();

        if (!$check) {
            return response()->json([
                'status' => false,
                'msg' => 'Account not found!'
            ]);
        } else {
            if($check->is_active == 0)
            {
                return response()->json([
                    'status' => false,
                    'msg' => 'Your account has not been approved yet'
                ]);
            }
            if (Hash::check($request->password, $check->password)) {
                return response()->json([
                    'status' => true,
                    'data' => $check
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'Invalid password!'
                ]);
            }
        }

    }
    
    
    
    public function update(Request $request)
    {
        $token = request()->bearerToken();

        $validator = Validator::make($request->all(), [
            'img' => 'nullable|image',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'house_no' => 'nullable',
            'vehicle_type' => 'nullable',
            'vehicle_model' => 'nullable',
            'color' => 'nullable',
            'number_plate' => 'nullable',
            'year_of_vehicle' => 'nullable',
            'license_no' => 'nullable',
            'number_plate' => 'nullable',
        ]);



        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }

        $user = Rider::where('token', $token)->first();

        if ($user) {
            if ($request->hasFile('img')) {
                # code...
                $filename = request()->getSchemeAndHttpHost() . '/storage/riders/upload/' . time() . '.' . $request->img->extension();

                $request->img->move(public_path('/storage/riders/upload/'), $filename);

                $user->img = $filename;
            }
            
            $check = Rider::where('email', $request->email)->first();
            
            if($check)
            {
                if($check->email != $request->email)
                {
                    $user->email = $request->email ?? $user->email;
                }
                else if($check->email == $user->email)
                {
                    $user->email = $request->email ?? $user->email;
                }
                else{
                    return response()->json([
                        'status' => false,
                        'msg' => 'Email is already taken!'
                    ]);
                }
            }
            
            $user->first_name = $request->first_name  ?? $user->first_name;
            $user->last_name = $request->last_name  ?? $user->last_name;
            // $user->phone = $request->phone ?? $user->phone;
            // $user->address = $request->address ?? $user->address;
            // $user->house_no = $request->phone ?? $user->house_no;
            // $user->vehicle_type = $request->vehicle_type ?? $user->vehicle_type;
            // $user->vehicle_model = $request->vehicle_model ?? $user->vehicle_model;
            // $user->color = $request->color ?? $user->color;
            // $user->number_plate = $request->number_plate ?? $user->number_plate;
            // $user->year_of_vehicle = $request->year_of_vehicle ?? $user->year_of_vehicle;
            // $user->lisence = $request->lisence ?? $user->lisence;

            $user->save();

            return response()->json([
                'status' => true,
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => false,
            'msg' => 'Invalid Token!'
        ]);
    }

    public function getLoginUser()
    {

        $token = request()->bearerToken();

        $rider = Rider::where('token', $token)->with('zone')->first();

        if ($rider) {
            return response()->json([
                'status' => true,
                'data' => $rider
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Account not found!'
            ]);
        }

    }
    
    
    public function updateLatLong(Request $request)
    {
        
        $token = request()->bearerToken();
        
        
        $rider = Rider::where('token', $token)->with('zone')->first();
        
        if($rider)
        {
            $rider->latitude = $request->latitude;
            $rider->longitude = $request->longitude;
            $rider->save();
            
            return response()->json([
                'status' => true,
                'data' => $rider
            ]);
            
        }
        
        return response()->json([
            'status' => false,
            'msg' => 'Account not found!'
        ]);
        
    }
    
    
    public function updateFcm(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }
        
        $token = request()->bearerToken();
        
        
        $rider = Rider::where('token', $token)->with('zone')->first();
        
        if($rider)
        {
            $rider->fcm_token = $request->fcm_token;
            $rider->save();
            
            return response()->json([
                'status' => true,
                'data' => $rider
            ]);
            
        }
        
        return response()->json([
            'status' => false,
            'msg' => 'Account not found!'
        ]);
        
    }
    
    
}
