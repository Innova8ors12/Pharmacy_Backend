<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PricingItem;
use App\Models\User;
use App\Models\Rider;
use App\Models\Pharmacy;
use App\Models\PrescriptionPricing;
use App\Models\StatusLog;
use App\Models\UploadPrescription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function checkLimit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pharmacy_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors()->first()
            ]);
        }
        
        $pharmacy = Pharmacy::where('id', $request->pharmacy_id)->first();
        if($pharmacy)
        {
            $today = Carbon::today()->format('Y-m-d'); // Get today's date in the right format
            $orders = Order::where('pharmacy_id', $request->pharmacy_id)
            ->whereDate('created_at', $today)
            ->count();
            // return $orders;
            if($orders > 3)
            {
                return response()->json([
                    'status' => false,
                    'msg' => 'Daily Order limit exceeds, this pharmacy currently not accepting any orders!!'
                ]);
                
            }
            else{
                
                $today = Carbon::today();
                
                // If today is Monday, start from today. Otherwise, start from the previous Monday.
                if ($today->isMonday()) {
                    $startOfWeek = $today->copy();
                } else {
                    $startOfWeek = $today->copy()->previous(Carbon::MONDAY);
                }
                
                $endOfWeek = $startOfWeek->copy()->addDays(6); // This will be the following Sunday
                
                $orders = Order::where('pharmacy_id', $request->pharmacy_id)
                            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                            ->count();
                            
                if($orders > 1)
                {
                    return response()->json([
                        'status' => false,
                        'msg' => 'Weekly Order limit exceeds, this pharmacy currently not accepting any orders!!'
                    ]);
                    
                }
                else{
                    $today = Carbon::today();
                    $startOfMonth = $today->copy()->startOfMonth(); // This will be the 1st day of the current month
                    $endOfMonth = $today->copy()->endOfMonth();     // This will be the last day of the current month
                    
                    $orders = Order::where('pharmacy_id', $request->pharmacy_id)
                                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                ->count();
                                
                    if($orders > 1)
                    {
                        return response()->json([
                            'status' => false,
                            'msg' => 'Monthly Order limit exceeds, this pharmacy currently not accepting any orders!!'
                        ]);
                        
                    }
                    else{
                        return response()->json([
                            'status' => true,
                            'data' => null
                        ]);
                    }
                }
            }
            
        }
        else{
            return response()->json([
                'status' => false,
                'msg' => 'Invalid Pharmacy Id!!'
            ]);
        }
        
    }

    public function makePayment(Request $request)
    {
        $getPresciption = UploadPrescription::where('id', $request->prescription_id)->first();

        $pharmacy = Pharmacy::where('id', $request->pharmacy_id)->first();

        // return response()->json([
        //     'status' => false,
        //     'msg' => 'Order placed successfully!',
        //     'data' => $firebaseToken
        // ],401);
        
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        $order= new Order;
        $order->user_id = $request->user_id;
        $order->upload_prescription_id = $request->prescription_id;
        $order->pharmacy_id = $request->pharmacy_id;
        $order->total_amount = $request->total_amount;
        $order->order_placed = Carbon::now()->toDateTimeString();
        $order->payment_status = $request->status;
        $order->payment_status_code = $request->status_code;
        $order->service_fee = $request->service_fee;
        $order->vat_price = $request->vat_price;
        $order->insurance_discount = $request->insurance_discount;
        $order->transaction_id = $request->transactionId;
        $order->transaction_date = $request->transaction_date;
        $order->delivery_status = 'Prescription is being Filled';
        $order->created_at = $newDateTime;
        $order->updated_at = $newDateTime;
        $order->latitude = $getPresciption->latitude;
        $order->longitude = $getPresciption->longitude;
        $order->save();

        if($order){
            if($request->item_name){
                foreach($request->item_name as $key => $value){
                    OrderItem::create([
                        'order_id' => $order->id,
                        'item_name' => $request->item_name[$key],
                        'quantity' => $request->quantity[$key],
                        'price' => $request->price[$key],
                        'removed_by_user' => $request->removed_by_user[$key]
                    ]);
                    
                    $pricingId=PrescriptionPricing::where('upload_prescription_id','=',$request->prescription_id)->first();
                     $pricingItems = PricingItem::whereIn('id',$request->item_id)->get();

                       PricingItem::whereNotIn('id',$request->item_id)->where('prescription_pricing_id', '=',$pricingId->id)->update([
                            'removed_by_user' => 1
                            ]);
                }
                 
            }
        }
        
        
        $firebaseToken = Rider::where('zone_id', $pharmacy->zone_id)
            ->whereNotNull('fcm_token')->pluck('fcm_token');
            
    
            $SERVER_API_KEY = 'AAAAuKGLKzk:APA91bGQZDZq15ZbBDfhsk0ANN_GaWHwBZJL1TtHT13fFdIs7UYgjLJ_LITWTNldLayCNlspEw09LUqpl0Cg308XIzwne8Ylcq59gsHyHE4mciqojHVabARHUl6bNuQGxrpDPR5V6S0N';
    
            // $token[] = 'J05WLuGqfP4Xj1Z9K8xJ_QwLroZHj8zJRENEffCCVsqn7XG56_XUp0A1VmceCSGRbP2NcyM2u2zlLrqOqsFWOAzO7zSnOesXlCO4qJLvp4l_dx4xOqmSNQB';
    
            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => 'You have received new order!',
                    "body" => 'New order available!',
                ]
            ];
            $dataString = json_encode($data);
    
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    
            $response = curl_exec($ch);

        $prescription= UploadPrescription::where('id','=',$request->prescription_id)->update([
            'status' => 'Prescription is being Filled'
        ]);

        $log = new StatusLog;
        $log->upload_prescription_id= $request->prescription_id;
        $log->status= 'Prescription is being Filled';
        $log->created_at = $newDateTime;
        $log->updated_at = $newDateTime;
        $log->save();
        

        $placed= Order::with('orderitem','prescription.statuslog')->where('upload_prescription_id','=',$request->prescription_id)->first();
        return response()->json([
            'status' => true,
            'msg' => 'Order placed successfully!',
            'data' => $placed
        ],200);
    }

	public function cancelOrder(Request $request)
	{
		$prescription = UploadPrescription::where('id', '=', $request->prescription_id)->update([
			'status' => 'Cancelled',
			'cancelled_by_pharmacy' =>0
		]);
		return response()->json([
			'status' => true,
			'msg' => 'Prescription cancelled'
		], 200);

	}

	public function deleteItem(Request $request)
	{
		$item = PricingItem::where('id', '=', $request->item_id)->delete();

		return response()->json([
			'status' => true,
			'msg' => 'Item removed'
		], 200);

	}
	
    public function getPharmacyOrder()
	{
		$access_token = request()->bearerToken();
		$pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
		if (!empty($pharmacy)) {
			$order = Order::where('pharmacy_id', '=', $pharmacy->id)->get();
			if ($order) {
				return response()->json([
					'status' => true,
					'data' => $order,
				], 200);
			} else {
				return response()->json([
					'status' => false,
					'data' => '',
				], 404);
			}
		} else {
			return response()->json([
				'status' => false,
				'msg' => 'unauthenticated',
			], 401);
		}
	}
	
    public function revisePrescription(Request $request)
	{
	    $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
		$pricingId = PrescriptionPricing::where('upload_prescription_id', '=', $request->prescription_id)->first();
		$pricingItems = PricingItem::whereIn('id', $request->item_id)->get();

		PricingItem::whereNotIn('id', $request->item_id)->where('prescription_pricing_id', '=', $pricingId->id)->update([
			'removed_by_user' => 1
		]);
		
		 $prescription= UploadPrescription::where('id','=',$request->prescription_id)->update([
            'status' => 'Pending Pricing'
        ]);
        
        $revised = PrescriptionPricing::where('upload_prescription_id', '=', $request->prescription_id)->update([
            'is_revised' => 1
            ]);
        $statuslog= StatusLog::where('upload_prescription_id','=',$request->prescription_id)->delete();
        
        $log = new StatusLog;
        $log->upload_prescription_id= $request->prescription_id;
        $log->status= 'Pending Pricing';
        $log->created_at = $newDateTime;
        $log->updated_at = $newDateTime;
        $log->save();

		return response()->json([
			'status' => true,
		], 200);
	}
}
