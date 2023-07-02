<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packageState extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'name'
    ];

    //relacionar con Sale
    public function sale(){
        return $this->hasMany(Sale::class);
    }
}
