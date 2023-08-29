<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id', 'upload_prescriptions_id', 'type', 'message','category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function prescription()
    {
        return $this->belongsTo(UploadPrescription::class, 'upload_prescriptions_id', 'id');
    }
}
