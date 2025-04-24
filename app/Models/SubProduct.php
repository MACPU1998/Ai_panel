<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProduct extends Model
{
    use HasFactory;
    protected $table = 'sub_products';
    protected $fillable = ['product_id','barcode','serie_year','serie_month','label','status'];

}
