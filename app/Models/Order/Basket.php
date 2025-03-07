<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'name', 'type', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
