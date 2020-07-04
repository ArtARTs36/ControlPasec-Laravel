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
 * @property int $id
 * @property double $price
 * @property int $quantity
 * @property VocabQuantityUnit $quantityUnit
 * @property int $quantity_unit_id
 * @property int $product_id
 * @property int $supply_id
 * @property Product $parent
 *
 * @mixin Builder
 */
class SupplyProduct extends Model
{
    public const RELATION_QUANTITY_UNIT = 'quantityUnit';
    public const RELATION_PARENT = 'parent';

    public const FIELD_PRICE = 'price';
    public const FIELD_QUANTITY = 'quantity';
    public const FIELD_PARENT_ID = 'product_id';
    public const FIELD_SUPPLY_ID = 'supply_id';
    public const QUANTITY_UNIT_ID = 'quantity_unit_id';

    protected $fillable = [
        self::FIELD_PRICE,
        self::FIELD_QUANTITY,
        self::FIELD_PARENT_ID,
        self::FIELD_SUPPLY_ID,
        self::QUANTITY_UNIT_ID,
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
