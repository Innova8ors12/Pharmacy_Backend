<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pharmacy extends Model
{
    
    use SoftDeletes;
    
    protected $fillable = [
        'pharmacy_name', 'email', 'password', 'location', 'phone', 'image', 'contact_person', 'country',
        'latitude', 'longitude', 'zone_id', 'merchant_id', 'authorize_key'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }


    public function prescription()
    {
        return $this->hasMany(UploadPrescription::class);
    }

    public function prescriptionpricing()
    {
        return $this->hasMany(PrescriptionPricing::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function withdrawal()
    {
        return $this->hasMany(WithdrawlRequest::class);
    }
}
