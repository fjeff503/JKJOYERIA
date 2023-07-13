<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;

    use SoftDeletes;

    //Nombre de la tabla
    protected $table = 'clients';

    //Llave primaria
    protected $primaryKey = 'idClient';

    protected $fillable = [
        'name',
        'phone',
        'whatsapp'
    ];

    //relacionar con sale
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
