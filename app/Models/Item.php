<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'stok',
        'price',
        'deskripsi',
        'image',
    ];


    public function orders()
{
    return $this->hasMany(Order::class, 'item_id');
}
   public function carts()
{
    return $this->hasMany(Cart::class, 'item_id');
    }
}
