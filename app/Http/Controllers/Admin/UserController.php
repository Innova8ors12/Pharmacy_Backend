<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        
         $customer = User::all();
        return view('Admin.User.index',compact('customer'));
    }
    
    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        
        $user->delete();
        
        return redirect()->back();
        
    }
}
