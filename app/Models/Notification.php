<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    
   protected $fillable=[
       'user_id', 'rider_id', 'pharmacy_id', 'upload_prescription_id','title','body','is_read'
   ];

   public function user(){
       return $this->belongsTo(User::class,'user_id','id');
   }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }

    public function prescription(){
        return $this->belongsTo(UploadPrescription::class, 'upload_prescription_id', 'id');
    }


   public function rider(){
       return $this->belongsTo(Rider::class,'rider_id','id');
   }
}
