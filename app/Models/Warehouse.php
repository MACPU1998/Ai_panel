<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Warehouse extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $table = 'warehouses';
    protected $fillable = [
        'name',
        'address',
        'status',
        'description',
        'make_default',
    ];

}
