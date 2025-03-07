<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'address'];

    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }
}
