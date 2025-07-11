<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;
    //Nombre de la tabla
    protected $table = 'products';

    //Llave primaria
    protected $primaryKey = 'idProduct';

    protected $fillable = [
        'codeProductProvider',
        'name',
        'sellPrice',
        'buyPrice',
        'stock',
        'description',
        'idCategory',
        'idProvider'
    ];

    //relacionar con category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //relacionar con provider
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    //relacionar con purchaseDetail
    public function purchaseDetail()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    //relacionar con saleDetail
    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class);
    }

    //relacionar con galery
    public function galery()
    {
        return $this->hasMany(Galery::class, 'idProduct');
    }
}
