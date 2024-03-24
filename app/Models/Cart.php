<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable=[
        'productId',
        'userId',
        'qty'
    ];

    public function product()
    {
        $this->belongsTo(product::class,'productId','id');
    }

    protected $appends=['total'];

    public function getTotalAttribute()
    {
        return $this->qty * $this->product->price;
    }

}
