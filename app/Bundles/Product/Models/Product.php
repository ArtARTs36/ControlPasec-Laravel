<?php

namespace App\Bundles\Product\Models;

use App\Models\Traits\WithOrderNumber;
use App\Models\VariableDefinition;
use App\Models\Vocab\SizeOfUnit;
use App\Bundles\Vocab\Models\VocabCurrency;
use App\Models\Vocab\VocabGosStandard;
use App\Models\Vocab\VocabPackageType;
use App\Models\Vocab\VocabQuantityUnit;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Product
 *
 * @property int $id
 *
 * @property string $name
 * @property string $name_for_document
 *
 * @property integer $size
 * @property integer $size_of_unit_id
 * @property SizeOfUnit $size_of_unit
 *
 * @property integer $price
 * @property integer $currency_id
 * @property integer $gos_standard_id
 * @property VocabGosStandard $gosStandard
 *
 * @property VocabPackageType $package_type
 * @property int $package_type_id
 *
 * @property VocabQuantityUnit $quantity_unit
 * @property int $quantity_unit_id
 *
 * @mixin Builder
 */
class Product extends Model
{
    use WithModifier, WithOrderNumber;

    public const ORDER_NUMBER_TYPE = VariableDefinition::PRODUCT_ORDER_NUMBER;

    public const FIELD_NAME = 'name';
    public const FIELD_NAME_FOR_DOCUMENT = 'name_for_document';
    public const FIELD_SIZE = 'size';
    public const FIELD_PRICE = 'price';
    public const FIELD_SIZE_OF_UNIT_ID = 'size_of_unit_id';
    public const FIELD_CURRENCY_ID = 'currency_id';
    public const FIELD_QUANTITY_UNIT_ID = 'quantity_unit_id';
    public const FIELD_PACKAGE_TYPE_ID = 'package_type_id';
    public const FIELD_GOS_STANDARD_ID = 'gos_standard_id';

    public const RELATION_CURRENCY = 'currency';
    public const RELATION_SIZE_OF_UNIT = 'sizeOfUnit';
    public const RELATION_GOS_STANDARD = 'gosStandard';

    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_NAME_FOR_DOCUMENT,
        self::FIELD_SIZE,
        self::FIELD_SIZE_OF_UNIT_ID,
        self::FIELD_PRICE,
        self::FIELD_CURRENCY_ID,
        self::FIELD_QUANTITY_UNIT_ID,
        self::FIELD_PACKAGE_TYPE_ID,
        self::FIELD_GOS_STANDARD_ID,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function sizeOfUnit(): BelongsTo
    {
        return $this->belongsTo(SizeOfUnit::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(VocabCurrency::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function gosStandard(): BelongsTo
    {
        return $this->belongsTo(VocabGosStandard::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function packageType(): BelongsTo
    {
        return $this->belongsTo(VocabPackageType::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function quantityUnit(): BelongsTo
    {
        return $this->belongsTo(VocabQuantityUnit::class);
    }
}
