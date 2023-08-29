<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function addRatings(Request $request){

        $check= Rating::where('user_id','=',$request->user_id)
        ->where('pharmacy_id','=',$request->pharmacy_id)->first();

        if($check){
          $update= Rating::where('user_id', '=', $request->user_id)
            ->where('pharmacy_id', '=', $request->pharmacy_id)->update([
                'star_rated' => $request->star_rated
            ]);

            $ratings = Rating::where('pharmacy_id', '=', $request->pharmacy_id)->get();
            $count= Rating::where('pharmacy_id', '=', $request->pharmacy_id)->sum('star_rated');
            $average=  $count/$ratings->count();

            $pharmacy= Pharmacy::where('id','=',$request->pharmacy_id)->update([
                'average_rating' => $average
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'thanks for rating',
                'data' => $average
            ], 200);
        }
        else{
           $rating = new Rating;
           $rating->user_id = $request->user_id;
           $rating->pharmacy_id=  $request->pharmacy_id;
           $rating->star_rated = $request->star_rated;
           $rating->save();

            $ratings = Rating::where('pharmacy_id', '=', $request->pharmacy_id)->get();
            $count = Rating::where('pharmacy_id', '=', $request->pharmacy_id)->sum('star_rated');
            $average =  $count/$ratings->count();

            $pharmacy = Pharmacy::where('id', '=', $request->pharmacy_id)->update([
                'average_rating' => $average
            ]);

            return response()->json([
                'status' => true,
                'msg' => 'thanks for rating',
                'data' => $average
            ],200);
        }
    }
}
