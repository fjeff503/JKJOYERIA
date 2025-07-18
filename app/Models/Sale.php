<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;
    //Nombre de la tabla
    protected $table = 'sales';

    //Llave primaria
    protected $primaryKey = 'idSale';
    protected $fillable = [
        'total',
        'description',
        'idClient',
        'idUser',
        'idDeliveryPoint',
        'idPackageState',
        'idPaymentState'  
    ];

// relacionar con client
public function client()
{
    return $this->belongsTo(Client::class, 'idClient', 'idClient');
}

// relacionar con deliveryPoint
public function deliveryPoint()
{
    return $this->belongsTo(DeliveryPoint::class, 'idDeliveryPoint', 'idDeliveryPoint');
}

    //relacionar con paymentState
    public function paymentState()
    {
        return $this->belongsTo(paymentState::class);
    }

    //relacionar con packageState
    public function packageState()
    {
        return $this->belongsTo(packageState::class);
    }

    //relacionar con users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relacionar con sale_details
    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
