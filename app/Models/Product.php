<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
class Product extends Model
{
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
		'image',
		'currency_id',
		'price',
		'final_price'
	];

	public function product_currency()
	{
		return $this->belongsTo(ProductCurrency::class, 'currency_id');
	}

	public function product_attributes()
	{
		return $this->hasMany(ProductAttribute::class);
	}

	public function product_categories()
	{
		return $this->hasMany(ProductCategory::class);
	}
}
