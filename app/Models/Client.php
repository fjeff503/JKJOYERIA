<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'phone',
        'whatsapp'
    ];

    //relacionar con sale
    public function sale(){
        return $this->hasMany(Sale::class);
     }
}
