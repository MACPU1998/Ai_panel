<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OrderSubProduct extends Model
{
    //
    use HasFactory;

    const STATUS_SOLD_OUT = 2;  //فروش رفته
    protected $table = 'order_sub_products';
    protected $fillable = [
        'order_id',
        'sub_product_id',
        'barcode'

    ];
    public function subProduct()
    {
        return $this->belongsTo(SubProduct::class, 'sub_product_id');


    }
    public function order(){
        return $this->belongsTo(Order::class, 'order_id');
    }

}

