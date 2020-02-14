<?php

namespace App\Models\Supply;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class SupplyProduct
 *
 * @property integer id
 * @property double price
 * @property integer mount
 * @property integer product_id
 * @property integer supply_id
 * @property Product parent
 *
 * @mixin Builder
 */
class SupplyProduct extends Model
{
    protected $fillable = [
        'price', 'mount', 'product_id', 'supply_id'
    ];

    public function parent()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
