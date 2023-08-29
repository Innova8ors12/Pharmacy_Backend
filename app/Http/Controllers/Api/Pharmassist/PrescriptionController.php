<?php

namespace App\Http\Controllers\Api\Pharmassist;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionPricing;
use App\Models\PricingItem;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\PrescriptionInstruction;
use App\Models\UploadPrescription;
use App\Models\StatusLog;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function getPrescriptions()
    {
       $access_token = request()->bearerToken();
       $pharmacy= Pharmacy::where('access_token','=',$access_token)->first();
       if(!empty($pharmacy)){
             $prescription = UploadPrescription::with('pharmacy','user','statuslog','instruction','prescriptionpricing.pricingitem')->where('pharmacy_id', '=', $pharmacy->id)->orderBy('id','DESC')->get();
        if($prescription){
              return response()->json([
            'status' => true,
            'data' => $prescription
        ],200);
        }
        else{
          return response()->json([
            'status' => FALSE,
            'data' => '',
        ],400);     
        }
       }
       else{
          return response()->json([
            'status' => FALSE,
            'msg' => 'unauthenticated',
        ],401);      
       }
      
      
    }

    public function prescriptionPricing(Request $request)
    {
         $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
       
        $pricing = new PrescriptionPricing;
        $pricing->user_id = $request->user_id;
        $pricing->pharmacy_id = $request->pharmacy_id;
        $pricing->upload_prescription_id = $request->prescription_id;
        $pricing->service_fee = $request->service_fee;
        $pricing->vat_price = $request->vat_price;
        $pricing->is_copayment = $request->is_copayment;
        $pricing->copayment_price = $request->copayment_price;
        $pricing->created_at = $newDateTime;
        $pricing->updated_at = $newDateTime;
        $pricing->save();

        if($request->medicine_name){
            foreach($request->medicine_name as $key => $item){
                PricingItem::create([
                    'prescription_pricing_id' => $pricing->id,
                    'medicine_name' => $request->medicine_name[$key],
                    'medicine_qty' => $request->medicine_qty[$key],
                    'medicine_price' => $request->medicine_price[$key],
                    'created_at' => $newDateTime,
                    'updated_at' => $newDateTime,
                ]);
            }
        }
            
                $status= new StatusLog;
                $status->upload_prescription_id = $request->prescription_id;
                $status->status = 'Pending Payment';
                $status->created_at = $newDateTime;
                $status->updated_at = $newDateTime;
                $status->save();
        
        $update = UploadPrescription::where('id','=', $request->prescription_id)->update([
            'status' => 'Pending Payment',
            'updated_at' => $newDateTime,
        ]);
        $data=  PrescriptionPricing::with('pricingitem','user','prescription.statuslog')->where('id','=', $pricing->id)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ],200);

    }
    
    public function updatePrescriptionPricing(Request $request){
        
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        
       
      $pricing= PrescriptionPricing::where('upload_prescription_id','=',$request->prescription_id)->update([
        'vat_price' => $request->vat_price,
        'is_copayment' => $request->is_copayment,
        'copayment_price' => $request->copayment_price
            ]);
            
            $id =  PrescriptionPricing::where('upload_prescription_id','=',$request->prescription_id)->first();
            if($id->is_revised == 1){
                   if($request->id){
                foreach($request->id as $key => $item){
                PricingItem::where('id','=',$request->id[$key])->update([
                    'medicine_name' => $request->medicine_name[$key],
                    'medicine_qty' => $request->medicine_qty[$key],
                    'medicine_price' => $request->medicine_price[$key],
                    'updated_at' => $newDateTime,
                ]);
            }
        }  
            }
            else{
                PricingItem::where('prescription_pricing_id','=',$id->id)->delete();
                
                   foreach($request->id as $key => $item){
                PricingItem::create([
                    'prescription_pricing_id' => $id->id,
                    'medicine_name' => $request->medicine_name[$key],
                    'medicine_qty' => $request->medicine_qty[$key],
                    'medicine_price' => $request->medicine_price[$key],
                     'created_at' => $newDateTime,
                    'updated_at' => $newDateTime,
                ]);
            }
            }
        
            
               
                
                 if($id->is_revised == 1)
                 {
                $status= new StatusLog;
                $status->upload_prescription_id = $request->prescription_id;
                $status->status = 'Pending Payment';
                $status->created_at = $newDateTime;
                $status->updated_at = $newDateTime;
                $status->save();
                 }
        
        $update = UploadPrescription::where('id','=', $request->prescription_id)->update([
            'status' => 'Pending Payment',
            'updated_at' => $newDateTime,
        ]);
        $data=PrescriptionPricing::with('pricingitem','user','prescription.statuslog')->where('id','=', $id->id)->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ],200);
    }
    
     public function getSinglePharmacy(){
           $access_token= request()->bearerToken();
        $pharmacy = Pharmacy::where('access_token', '=', $access_token)->first();
        if($pharmacy){
              return response()->json([
            'status' => TRUE,
            'data' => $pharmacy,
            
        ],200);
        }else{
            return response()->json([
            'status' => FALSE,
            'data' => '',
        ],400); 
        }
      
    }
    
     public function getSinglePrescription($id)
    {
        $prescription= uploadPrescription::with('user','pharmacy','statuslog','instruction','prescriptionpricing.pricingitem', 'rider')->where('id','=',$id)->first();
        if(!empty($prescription)){
            return response()->json([
                'status' => true,
                'data' => $prescription
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => ''
            ], 400);
        }
    }
    
    	public function cancelOrderPharmacy(Request $request)
	{
	     $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
		$prescription = UploadPrescription::where('id', '=', $request->prescription_id)->update([
			'status' => 'Cancelled',
			'cancelled_by_pharmacy' =>1,
			'cancelled_reason' => $request->cancel_reason,
			 'updated_at' => $newDateTime,
		]);
		return response()->json([
			'status' => true,
			'msg' => 'Prescription cancelled'
		], 200);

	}
    
    public function pickupStatus(Request $request){
          $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        
        $prescription = UploadPrescription::where('id','=',$request->prescription_id)->update([
            'status' => $request->status,
             'updated_at' => $newDateTime,
        ]);

        if($prescription){
          $order = Order::where('upload_prescription_id','=',$request->prescription_id)->update([
              'delivery_status' => $request->status,
               'updated_at' => $newDateTime,
              ]);
          
            $log = new StatusLog;
            $log->upload_prescription_id = $request->prescription_id;
            $log->status = $request->status;
            $log->created_at = $newDateTime;
            $log->updated_at = $newDateTime;
            $log->save();
            return response()->json([
                'status' => true,
            ],200);
        }
        else{
            return response()->json([
                'status' => true,
            ], 200);
        }

    }
    
     public function prescriptionInstruction(Request $request)
    {
          $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(4);
        
        $instruction = new PrescriptionInstruction;
        $instruction->upload_prescription_id = $request->prescription_id;
        $instruction->text = $request->text;
        if ($request->hasFile('file')) {
            $file =  $request->file('file');
            $filename =  $file->getClientOriginalName();
            $move =  $file->move('storage/instruction/',$filename);
            $host = request()->getSchemeAndHttpHost();
            $url = $host.'/'.$move;
            $instruction->file = $url;
        }
          $instruction->created_at = $newDateTime;
            $instruction->updated_at = $newDateTime;
        $instruction->save();
        return response()->json([
            'status' => true,
            'data' => $instruction
        ], 200);
    }
    
     public function updateInstruction(Request $request)
    {
        if($request->removeImage == 'false')
        {
             if ($request->hasFile('file')) {
            $file =  $request->file('file');
            $filename =  $file->getClientOriginalName();
            $move =  $file->move('storage/instruction/',$filename);
            $host = request()->getSchemeAndHttpHost();
            $url = $host.'/'.$move;
        }
            $ins = PrescriptionInstruction::where('id','=',$request->instruction_id)->first();
           
             $update = PrescriptionInstruction::where('id','=',$request->instruction_id)->update([
                'text' => $request->text ?? '',
                'file' => $url ?? $ins->file
            ]);
            
            return response()->json([
                'status' => true,
            ], 200);
        }
        else
        {
               if ($request->hasFile('file')) {
            $file =  $request->file('file');
            $filename =  $file->getClientOriginalName();
            $move =  $file->move('storage/instruction/',$filename);
            $host = request()->getSchemeAndHttpHost();
            $url = $host.'/'.$move;
        }
        
            $update = PrescriptionInstruction::where('id','=',$request->instruction_id)->update([
                    'text' => $request->text ?? '',
                    'file' => $url ?? Null,
                ]);
                
                
            
            return response()->json([
                'status' => true,
            ], 200);
        }
      
    }
    
    
      public function deleteInstruction($id)
    {
           $ins = PrescriptionInstruction::where('id','=',$id)->first();
           if(!empty($ins)){
               $ins->delete();
                    return response()->json([
                    'status' => true,
                ], 200); 
           }
           else{
             return response()->json([
                    'status' => false,
                ], 200);    
           }
    }
}
