<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KanooPayController extends Controller
{
    public function payment(Request $request){
        return $request->all();
    }
    
     public function paymentBack(){
        return view('payment2');
    }
    
     
    public function privacy()
    {
        return view('privacy');
    }
    
    public function terms()
    {
        return view('terms');
    }
    
}
