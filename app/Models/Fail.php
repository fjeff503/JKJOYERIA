<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fail extends Model
{
    use HasFactory;

    //Nombre de la tabla
    protected $table = 'fails';

    //Llave primaria
    protected $primaryKey = 'idFail';

    protected $fillable = [
        'tableName',
        'action',
        'message',
        'file',
        'line'
    ];
}
