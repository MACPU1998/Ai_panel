<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    use HasFactory;
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'sub_product_id',
        'quantity',
        'price',
        'status'
    ];

    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}
