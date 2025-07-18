<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    //Nombre de la tabla
    protected $table = 'sale_details';

    //Llave primaria
    protected $primaryKey = 'idSaleDetail';

    protected $fillable = [
        'quantity',
        'price',
        'discount',
        'idProduct',
        'idSale'
    ];

    //relacionar con product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //relacionar con sale
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
