<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'total_price',
        'final_price',
        'shipping_price',
        'tax_price',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);

    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
