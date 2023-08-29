<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingItem extends Model
{
        protected $fillable=[
        'prescription_pricing_id','medicine_name','medicine_qty','medicine_price'
        ];

        public function prescriptionpricing(){
            return $this->belongsTo(PrescriptionPricing::class, 'prescription_pricing_id','id');
        }
}
