<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawlRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdraw = WithdrawlRequest::orderBy('created_at','DESC')->get();
        return view('Admin.Withdrawal.index', compact('withdraw'));
    }
    
     public function transaction($id){
        $record = WithdrawlRequest::find($id);
        return view('Admin.Withdrawal.transaction',compact('record'));
    }
    
    public function approveWithdrawal(Request $request){
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kanoo-gateway-sandbox.kardsys.com/visikard/api/external/merchant/login',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
              'username' => 'pharmassist2022@gmail.com',
              'password' => 'Kanoo1234',
              'deviceId' => 'VISIKARD-XXXX-XXXX-WEB',
              'appPlatform' => 1,
              ),
        ));
        
        $responses = curl_exec($curl);
        
        curl_close($curl);
        $token = json_decode($responses,true);
        if($token['statusCode'] == 'SUCCESS'){
           $apitoken =  $token['result']['loginInformation']['token'];
           
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://kanoo-gateway-sandbox.kardsys.com/visipay/api/external/payment/transferMoneyByEmail',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
              'recipientEmail' => $request->kano_email, 
              'amount' => $request->amount,
              ),
          CURLOPT_HTTPHEADER => array(
            'deviceId: VISIKARD-XXXX-XXXX-WEB',
            'token: '.$apitoken.''
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        $transfer = json_decode($response,true);
        if($transfer['statusCode'] == 'SUCCESS'){
            $withdrawal = WithdrawlRequest::where('id','=',$request->withdrawal_id)->update([
                'status' => 'Approved'
                ]);
                
                foreach($request->prescription_id as $key => $value){
                    Order::whereIn('upload_prescription_id',$request->prescription_id[$key])->update([
                        'withdrawal_status' => 'Paid'
                        ]);
                }
                
                return response()->json([
                    'status' => true,
                    'msg' => 'Payment Approved!'
                    ]);
        }
        else{
            
                      foreach ($request->prescription_id as $key =>  $value) {
                           $update = Order::whereIn('upload_prescription_id',array($request->prescription_id[$key]))->update([
                'withdrawal_status' => 'Unpaid'
                ]);
                    
                }

               $withdrawal = WithdrawlRequest::where('id','=',$request->withdrawal_id)->update([
                'status' => 'Invalid Email'
                ]);
                
                  return response()->json([
                    'status' => false,
                    'msg' => 'Invalid Email!'
                    ]);
        }
  
        }
      
    }
}
