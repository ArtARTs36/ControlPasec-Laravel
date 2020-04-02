<?php

namespace App\Models\Supply;

use App\Models\Product\Product;
use App\Models\Vocab\VocabQuantityUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class SupplyProduct
 *
 * @property integer $id
 * @property double $price
 * @property integer $quantity
 * @property VocabQuantityUnit $quantityUnit
 * @property integer $quantity_unit_id
 * @property integer $product_id
 * @property integer $supply_id
 * @property Product $parent
 *
 * @mixin Builder
 */
class SupplyProduct extends Model
{
    protected $fillable = [
        'price', 'quantity', 'product_id', 'supply_id', 'quantity_unit_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function quantityUnit(): BelongsTo
    {
        return $this->belongsTo(VocabQuantityUnit::class);
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return round((float) $this->price * $this->quantity);
    }
}
