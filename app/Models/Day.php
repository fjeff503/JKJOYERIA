<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name'
    ];

    //relacionar con DeliveryPoint
    public function deliveryPoint(){
        return $this->hasMany(DeliveryPoint::class);
    }
}
