<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total',
        'status',
        'description',
        'idPaymentState',
        'idPackageState',
        'idClient',
        'idDeliveryPoint',
        'idUser'
    ];

    //relacionar con client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    //relacionar con deliveryPoint
    public function deliveryPoint()
    {
        return $this->belongsTo(DeliveryPoint::class);
    }

    //relacionar con paymentState
    public function paymentState()
    {
        return $this->belongsTo(paymentState::class);
    }

    //relacionar con paymentState
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
