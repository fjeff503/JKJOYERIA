<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryPoint extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name',
        'day',
        'hour',
        'description',
        'status',
        'idParcel'
    ];


    //relacionar con parcel
    public function parcel(){
        return $this->belongsTo(Parcel::class);
    }

    //relacionar con day
    public function day(){
        return $this->belongsTo(Day::class);
    }

    //relacionar con sale
    public function sale(){
        return $this->hasMany(Sale::class);
     }
}
