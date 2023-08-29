<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable=[
        'order_id','item_name','quantity','price','removed_by_user'
    ];

    public function order(){
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
