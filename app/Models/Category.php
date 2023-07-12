<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $perPage = 10; // Establece un límite por defecto de 10 elementos por página

    //Nombre de la tabla
    protected $table = 'categories';

    //Llave primaria
    protected $primaryKey = 'idCategory';

    protected $fillable = [
        'name',
        'description'
    ];

    //relacionar con product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
