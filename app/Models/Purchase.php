<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'idPurchase',
        'date',
        'total',
        'voucher',
        'status',
        'idProvider',
        'idUser'
    ];

    //relacionar con users
    public function user(){
        return $this->belongsTo(User::class);
     }

    //relacionar con providers
    public function provider(){
        return $this->belongsTo(Provider::class);
     }

    //relacionar con purchase_details
    public function purchaseDetails(){
        return $this->hasMany(PurchaseDetail::class);
     }
}
