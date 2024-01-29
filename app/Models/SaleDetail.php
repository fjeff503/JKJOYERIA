<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

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
