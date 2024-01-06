<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use HasFactory;

    use SoftDeletes;

    //Nombre de la tabla
    protected $table = 'parcels';

    //Llave primaria
    protected $primaryKey = 'idParcel';

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
