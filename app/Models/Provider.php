<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory;

    use SoftDeletes;

    //Nombre de la tabla
    protected $table = 'providers';

    //Llave primaria
    protected $primaryKey = 'idProvider';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'facebook',
        'whatsapp',
        'description'
    ];

    //relacionar con product
    public function product()
    {
        return $this->hasMany(Product::class);
    }

    //relacionar con purchase
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
