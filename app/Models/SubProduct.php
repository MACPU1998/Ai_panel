<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProduct extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_INACTIVE = 0;
    const STATUS_AVAILABLE = 1;
    const STATUS_RETURNED = 2;

    public static $statusLabels = [
        self::STATUS_INACTIVE => 'غیر فعال',
        self::STATUS_AVAILABLE => 'فعال',
        self::STATUS_RETURNED => 'مرجوعی',

    ];


    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? 'نامشخص';
    }

    protected $table = 'sub_products';
    protected $fillable = ['product_id', 'barcode', 'serie_year', 'serie_month', 'label', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_sub_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
