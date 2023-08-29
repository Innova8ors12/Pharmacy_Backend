<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionPricing;
use App\Models\UploadPrescription;
use App\Models\User;
use App\Models\StatusLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class UploadPrescriptionController extends Controller
{
    public function uploadPrescription(Request $request){
        $validator = Validator::make($request->all(),[
            'prescription_name' => 'required',
            'prescription_image' => 'required|mimes:png,jpg',
            'latitude' => 'required',
            'longitude' => 'required',
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ],400);
        }
        else{
            
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->subHours(4);
          
            $prescription = new UploadPrescription;
            $prescription->user_id = $request->user_id;
            $prescription->pharmacy_id = $request->pharmacy_id;
            $prescription->prescription_name = $request->prescription_name;

            if($request->file('prescription_image')){
                $file = $request->file('prescription_image');
                $filename = $file->getClientOriginalName();
                $move = $file->move('storage/prescription/',$filename);
                $host = $request->getSchemeAndHttpHost();
                $url = $host.'/'.$move;
                $prescription->prescription_image = $url;
            }

            if ($request->file('insurance_image')) {
                $file1 = $request->file('insurance_image');
                $filename1 = time().'.'.$file1->getClientOriginalExtension();
                $move1 = $file1->move('storage/prescription/',$filename1);
                $gethost1 = $request->getSchemeAndHttpHost();
                $url1 = $gethost1.'/'.$move1;
                $prescription->insurance_image = $url1;
            }
            $prescription->latitude = $request->latitude;
            $prescription->longitude = $request->longitude;
            $prescription->street = $request->street;
            $prescription->date = $request->date;
            $prescription->city = $request->city;
            $prescription->state = $request->state;
            $prescription->address = $request->address;
            $prescription->address_type = $request->address_type;
            $prescription->building_name = $request->building_name;
            $prescription->house_no = $request->house_no;
            $prescription->note = $request->note;
            $prescription->status = 'Pending Pricing';
            $prescription->created_at = $newDateTime;
            $prescription->updated_at = $newDateTime;
            $prescription->save();

            if($prescription){
                $status= new StatusLog;
                $status->upload_prescription_id = $prescription->id;
                $status->status = 'Pending Pricing';
                $status->created_at = $newDateTime;
                $status->updated_at = $newDateTime;
                $status->save();
            }

            $prescriptions= UploadPrescription::with('statuslog')->where('id','=',$prescription->id)->first();
            return response()->json([
                'status' => true,
                'msg' => 'Prescription submitted for pricing',
                'data' => $prescriptions
            ],200);
        }
    }

    public function getPricing($id)
    {
        $pricing = PrescriptionPricing::with('pricingitem')->where('user_id','=',$id)->get();
        return response()->json([
            'status' => true,
            'code' => 200,
            'data' => $pricing
        ]);
    }
    
    public function getCustomerPrescriptions(Request $request)
    {
       
       $access_token = request()->bearerToken();
       $user= User::where('access_token','=',$access_token)->first();
       
       $prescription=UploadPrescription::with('user','pharmacy','statuslog','instruction','prescriptionpricing.pricingitem', 'rider')->where('user_id','=',$user->id)->orderBy('id','DESC')->get();
       
       if(!empty($prescription)){
            return response()->json([
                'status' => true,
                'data' => $prescription
                ],200);
      }
      else{
          return response()->json([
                'status' => false,
                'data' => ''
                ],400); 
      }
    }
    
    public function getSinglePrescription($id)
    {
        $prescription= UploadPrescription::with('statuslog','instruction','prescriptionpricing.pricingitem','user', 'rider', 'pharmacy')->where('id','=',$id)->first();
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
    
     public function updatePrescriptionImage(Request $request){

        if($request->file('prescription_image')){
            $file = $request->file('prescription_image');
            $filename = $file->getClientOriginalName();
            $move = $file->move('storage/prescription/',$filename);
            $host = $request->getSchemeAndHttpHost();
            $url = $host.'/'.$move;
        }

        $image= uploadPrescription::where('id','=',$request->prescription_id)->update([
            'prescription_image' => $url,
            'prescription_name' => $request->prescription_name
        ]);
        
         return response()->json([
            'status' => true,
            'msg' => 'Updated successfully!'
        ],200);
    }
}
