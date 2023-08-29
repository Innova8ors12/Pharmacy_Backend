<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Rider extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [

        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'house_no',
        'password',
        'vehicle_type',
        'vehicle_model',
        'color',
        'number_plate',
        'year_of_vehicle',
        'token',
        'otp',
        'latitude',
        'longitude',
        'license_no',
        'island',
        'zone_id'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
    
    public function getzone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

}
