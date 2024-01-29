<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

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
