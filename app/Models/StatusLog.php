<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $fillable=[
            'upload_prescription_id','status'
    ];

    public function prescription(){
        return $this->belongsTo(UploadPrescription::class, 'upload_prescription_id','id');
    }
}
