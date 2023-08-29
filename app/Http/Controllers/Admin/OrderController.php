<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $order= Order::where('delted_at', '!=', 'NULL')->get();
        return view('Admin.Order.index',compact('order'));
    }

    public function details($id){
        $details= Order::find($id);
        return view('Admin.Order.detail',compact('details'));
    }

}
