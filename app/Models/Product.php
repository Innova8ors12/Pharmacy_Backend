<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'name','price','description','status','quantity','main_img'
    ];

    public function images(){
        return $this->hasMany(ProductImages::class);
    }
}
