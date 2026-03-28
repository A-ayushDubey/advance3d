<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'total',
        'status',
        'payment_id',
        'payment_status'
    ];

    // 🔥 ADD THIS
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}