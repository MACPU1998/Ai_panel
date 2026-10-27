<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;

    const STATUS_CANCEL = 0;
    const STATUS_SHOPPING_CART= 1;  //سبد خرید
    const STATUS_PAYMENT  = 2; //پرداخت مشتری
    const STATUS_CONFIRMATION = 3;  //تایید ادمین
    const STATUS_PROCESSING = 4;  //پردازش
    const STATUS_READY_TO_SEND = 5;  //آماده به ارسال
    const STATUS_SEND = 6;  //ارسال

    public static $statusLabels = [
        self::STATUS_CANCEL => 'لغو شده',
        self::STATUS_SHOPPING_CART => 'سبد خرید',
        self::STATUS_PAYMENT => 'پرداخت شده',
        self::STATUS_CONFIRMATION => 'تایید ادمین',
        self::STATUS_PROCESSING => 'در حال پردازش',
        self::STATUS_READY_TO_SEND => 'آماده ارسال',
        self::STATUS_SEND => 'ارسال شده',
    ];


    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? 'نامشخص';
    }

    protected $table = 'orders';
    protected $fillable = [
        'customer_id',
        'shipping_price',
        'tax_price',
        'total_price',
        'final_price',
        'quantity',
        'status',
        'payment_method',
        'cash_amount',
        'card_amount',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function subProducts()
    {
        return $this->belongsToMany(SubProduct::class, 'order_sub_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
