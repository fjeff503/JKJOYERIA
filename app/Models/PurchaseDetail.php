<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    //Nombre de la tabla
    protected $table = 'purchase_details';

    //Llave primaria
    protected $primaryKey = 'idPurchaseDetail';

    protected $fillable = [
        'quantity',
        'price',
        'idProduct',
        'idPurchase'
    ];

    //relacionar con purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    //relacionar con product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
