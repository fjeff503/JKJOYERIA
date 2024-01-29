<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryPoint extends Model
{
    use HasFactory;

    use SoftDeletes;
    //Nombre de la tabla
    protected $table = 'delivery_points';

    //Llave primaria
    protected $primaryKey = 'idDeliveryPoint';

    protected $fillable = [
        'name',
        'hour',
        'description',
        'idParcel',
        'idDay'
    ];


    //relacionar con parcel
    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    //relacionar con day
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    //relacionar con sale
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
