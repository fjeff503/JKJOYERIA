<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'galeries';

    //Llave primaria
    protected $primaryKey = 'idGalery';

    protected $fillable = [
        'url',
        'idProduct'
    ];

    //relacionar con productos
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
