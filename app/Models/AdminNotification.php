<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable=[
        'pharmacy_name','country','is_seen','title'
    ];
}
