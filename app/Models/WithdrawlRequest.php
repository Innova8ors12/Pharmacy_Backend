<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawlRequest extends Model
{
    protected $fillable = [
        'pharmacy_id', 'amount', 'status'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class, 'pharmacy_id', 'id');
    }
    
     public function withdrawalrecord(){
        return $this->hasMany(WithdrawlRecord::class);
    }
}
