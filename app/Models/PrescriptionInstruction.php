<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionInstruction extends Model
{
    protected $fillable = [
        'upload_prescription_id', 'text', 'file'
    ];

    public function prescription(){
        return $this->belongsTo(UploadPrescription::class, 'upload_prescription_id','id');
    }
}
