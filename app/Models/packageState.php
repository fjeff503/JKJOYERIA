<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class packageState extends Model
{
    use HasFactory;

    use SoftDeletes;

    //Nombre de la tabla
    protected $table = 'package_states';

    //Llave primaria
    protected $primaryKey = 'idPackageState';

    protected $fillable = [
        'name',
        'description'
    ];

    //relacionar con Sale
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
