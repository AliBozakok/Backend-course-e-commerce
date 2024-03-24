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
        $this->belongsTo(Category::class,'categoryId','id');
    }

    public function scopeGetActive()
    {
        return $this->where('qunatityInStock','!=',0);
    }
}
