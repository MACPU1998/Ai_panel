<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductAttribute
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property bool $status
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Product $products
 *
 * @package App\Models
 */
class ProductAttribute extends Model
{
    use HasFactory,SoftDeletes;
	protected $table = 'product_attributes';

	protected $casts = [
		'status' => 'bool',
		'product_id' => 'int'
	];

	protected $fillable = [
		'name',
		'value',
		'status',
		'product_id'
	];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
