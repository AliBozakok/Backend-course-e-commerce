<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'description',
        'imgUrl',
        'price',
        'qunatityInStock',
        'categoryId'
    ];

    public function category()
    {
        return  $this->belongsTo(Category::class,'categoryId','id');
    }

    public function scopeGetActive()
    {
        return $this->where('qunatityInStock','>=',0);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
