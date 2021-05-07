<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function product()
    {
        return $this->hasManyThrough(
          Product::class,
          OrderProduct::class,
          'order_id',
          'id',
          'id',
          'product_id'
        );
    }
}
