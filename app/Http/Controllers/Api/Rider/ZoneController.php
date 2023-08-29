<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Rider;
use App\Models\Notification;
use Illuminate\Http\Request;

class ZoneController extends Controller
{

    public function getAll()
    {
        $zone = Zone::all();

        return response()->json([
            'status' => true,
            'zone' => $zone
        ]);
    }
    
    public function assignZone(Request $request, $id)
    {
        // dd($request->all());   
        $rider = Rider::where('id', $id)->first();
        
        $rider->zone_id = $request->zone_id;
        $rider->save();
        
        Notification::create([
            'rider_id' => $rider->id,
            'title' => 'Order has been ' . $request->status,
            'body' => 'Order has been ' . $request->status,
            'is_read' => 0
        ]);
        
        return redirect()->back();
        
    }


}
