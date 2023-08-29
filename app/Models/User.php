<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'date_of_birth',
        'country',
        'phone',
        'insurance',
        'username',
        'user_image',
        'access_token',
        'purchases_amount'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function prescription(){
        return $this->hasMany(UploadPrescription::class);
    }

    public function prescriptionpricing(){
        return $this->hasMany(PrescriptionPricing::class);
    }

     public function order(){
        return $this->hasMany(Order::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
