<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawlRecord extends Model
{
    protected $fillable = [
        'withdrawl_request_id', 'upload_prescription_id'
    ];

    public function withdrawalrequest()
    {
        return $this->belongsTo(WithdrawlRequest::class, 'withdrawl_request_id', 'id');
    }

    public function prescription()
    {
        return $this->belongsTo(UploadPrescription::class, 'upload_prescription_id', 'id');
    }
}
