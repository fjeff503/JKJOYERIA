<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'idRole';
    
    protected $fillable = [
        'name'
    ];

    //relacionar con user
    public function user()
    {
        return $this->hasMany(User::class);
    }
}
