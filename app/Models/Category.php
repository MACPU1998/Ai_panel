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

/**
 * Class Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|ProductCategory[] $product_categories
 *
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory,SoftDeletes;
	protected $table = 'categories';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'name',
		'slug',
		'status'
	];

	public function product_categories()
	{
		return $this->hasMany(ProductCategory::class);
	}
}
