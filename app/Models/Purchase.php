<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;

    use SoftDeletes;
    //Nombre de la tabla
    protected $table = 'purchases';

    //Llave primaria
    protected $primaryKey = 'idPurchase';

    protected $fillable = [
        'total',
        'voucher',
        'idProvider',
        'idUser'
    ];

    //relacionar con users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relacionar con providers
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    //relacionar con purchaseDetails
    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
