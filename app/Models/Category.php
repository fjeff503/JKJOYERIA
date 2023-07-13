<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    use SoftDeletes;

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
