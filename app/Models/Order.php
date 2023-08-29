<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
        'user_id','pharmacy_id', 'rider_id', 'upload_prescription_id','total_amount','order_placed','delivery_status','payment_status'
    ];

    public function pharmacy(){
        return $this->belongsTo(Pharmacy::class,'pharmacy_id','id');
    }
    
    public function rider(){
        return $this->belongsTo(Rider::class,'rider_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }

    public function prescription(){
    return $this->belongsTo(UploadPrescription::class, 'upload_prescription_id','id');
    }
}
