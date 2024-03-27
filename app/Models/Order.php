<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        'userId',
        'total',
        'address',
        'phone'
    ];

    public function user()
    {
      return  $this->belongsTo(User::class,'userId','id');
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'orderId','id');
    }
}
