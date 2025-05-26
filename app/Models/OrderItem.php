<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    use HasFactory;

    const STATUS_CANCELED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_SOLD_OUT = 2;  //فروش رفته

    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'sub_product_id',
        'quantity',
        'price',
        'product_name',
        'total_price',
        'status'
    ];

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
