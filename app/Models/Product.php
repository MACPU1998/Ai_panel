<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $status
 * @property string $image
 * @property int $currency_id
 * @property int $price
 * @property int|null $final_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property ProductCurrency $product_currencies
 * @property Collection|ProductAttribute[] $product_attributes
 * @property Collection|ProductCategory[] $product_categories
 *
 * @package App\Models
 */
class Product extends Model implements HasMedia
{
    use InteractsWithMedia,HasFactory,SoftDeletes;

    protected $table = 'products';


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    protected $casts = [
        'status' => 'bool',
        'currency_id' => 'int',
        'price' => 'int',
        'final_price' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'currency_id',
        'serial_prefix',
        'price',
        'final_price'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->attributes()->delete();
        });
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }


    public function currency()
    {
        return $this->belongsTo(ProductCurrency::class, 'currency_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('product_images')->singleFile();
    }

    public function subProduct()
    {
        return $this->hasMany(SubProduct::class, 'product_id');

    }


    public function activeSubProducts()
    {
        return $this->hasMany(SubProduct::class, 'product_id')->where('status', 1);
    }

    public function productCategorie()
    {
        return $this->hasMany(ProductCategory::class);

    }

}
