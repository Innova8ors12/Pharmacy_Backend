<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getDashboard(){
        $totalorder= Order::count();
        $recent= Order::latest()->take(4)->get();
        $recentuser= User::latest()->take(5)->get();
        $earning= Order::sum('total_amount');
        $totaluser= User::count();
        $recentpharmacy = Pharmacy::latest()->take(5)->get();
        return view('Admin.Dashboard.index',compact('totalorder','recent', 'earning','totaluser','recentuser','recentpharmacy'));
    }
}
