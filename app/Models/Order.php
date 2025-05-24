<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_FAILED = 4;

    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'shipping_price',
        'tax_price',
        'total_price',
        'final_price',
        'quantity',
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
