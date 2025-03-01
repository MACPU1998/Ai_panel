<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    use InteractsWithMedia,HasFactory;

    protected $table = 'products';

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
      //  'image',
        'currency_id',
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
        $this->addMediaCollection('product_images')->singleFile(); // ذخیره فقط یک عکس
    }

}
