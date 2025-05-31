<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE= 1;

    public static $statusLabels = [
        self::STATUS_INACTIVE => 'غیر فعال',
        self::STATUS_ACTIVE => 'فعال',
    ];


    public function getStatusLabelAttribute()
    {
        return self::$statusLabels[$this->status] ?? 'نامشخص';
    }


    protected $table = 'warehouses';
    protected $fillable = [
        'name',
        'address',
        'status',
        'description',

    ];

    public function subProducts()
    {
        return $this->hasMany(SubProduct::class);
    }

}
