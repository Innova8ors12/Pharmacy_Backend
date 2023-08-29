<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function profile()
    {
        return view('Admin.Auth.profile');
    }

    public function login()
    {
        return view('Admin.Auth.login');
    }
    
      public function authentication(Request $request)
    {

        $admin = Admin::where('email', '=', $request->email)->count();
        $check = Admin::where('email', '=', $request->email)->first();
        if ($admin == 0) {
            return response()->json([
                'code' => 404,
                'msg' => 'Invalid login credentails'
            ]);
        }
        elseif (!Hash::check($request->password, $check->password)) {
            return response()->json([
                'code' => 404,
                'msg' => 'Invalid login credentails'
            ]);
        }
        else {
            $data= Session::put('admin', $check);
            return response()->json([
                'msg' => 'Login successfully!',
                'data' => $data
            ]);
        }
    }
    
     public function logout()
     {
        $destroy = Session::forget('admin');
        return redirect()->route('admin.login.index');
     }
    
        public function profileUpdate(Request $request)
      {
        $update = Admin::where('id', '=', Session::get('admin')['id'])->update([
            
            'fullname' => $request->fullname ?? Session::get('admin')['fullname'],
            'email' => $request->email ?? Session::get('admin')['email']
        ]);
        
        Session::forget('admin');
            
         $admin =  Admin::where('email', '=', $request->email)->first();
         $data= Session::put('admin', $admin);
        return response()->json([
            'msg' => 'Profile updated successfully!',
            'data' => $data
        ]);
     }
     
     public function changePass(Request $request){
        $user= Admin::where('id','=',$request->user_id)->first();
        
        if(!Hash::check($request->old_password,$user->password)){
             return response()->json([
                 'status' => false,
            'msg' => 'Password does not match!',
        ]);
        }else{
           $update = Admin::where('id', '=', $request->user_id)->update([
            
           'password' => Hash::make($request->password)
        ]);  
         return response()->json([
                 'status' => true,
            'msg' => 'Password changed successfully!',
            ]);
        }
    }
    
    public function isSeen($id){
        $noti = AdminNotification::where('id','=',$id)->update([
            'is_seen' => 1
            ]);
        return redirect()->route('admin.pharmacy.index');
    }
}
