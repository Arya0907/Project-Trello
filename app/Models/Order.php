<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
    'user_id',
    'items',
    'name_customer',
    'total_price'
    ];

    protected $casts = [
        'items' => 'array'
    ];

    public function User()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function Items()
{
    return $this->hasMany(Item::class);
}
}
