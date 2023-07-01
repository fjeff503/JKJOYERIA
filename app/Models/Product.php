<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'idProduct',
        'codeProduct',
        'codeProductProvider',
        'name',
        'sellPrice',
        'stock',
        'status',
        'description',
        'idCategory',
        'idProvider'
    ];

    //relacionar con category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //relacionar con provider
    public function provider(){
        return $this->belongsTo(Provider::class);
    }

}
