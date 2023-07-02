<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'phone',
        'whatsapp',
        'facebook'
    ];

    //relacionar con DeliveryPoint
    public function deliveryPoint(){
        return $this->hasMany(DeliveryPoint::class);
    }

}