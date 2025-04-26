<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['product_id', 'barcode', 'serial_date', 'version', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
