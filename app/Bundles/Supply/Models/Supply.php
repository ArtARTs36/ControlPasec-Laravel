<?php

namespace App\Bundles\Supply\Models;

use App\Bundles\Contragent\Models\Contragent;
use App\Based\ModelSupport\WithOrderNumber;
use App\Bundles\Supply\Support\WithSupplierAndCustomer;
use App\Bundles\Admin\Models\VariableDefinition;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * Модель "поставка"
 *
 * @property integer $id
 * @property string|\DateTime $planned_date
 * @property string|\DateTime $execute_date
 * @property int $supplier_id
 * @property int $customer_id
 * @property Contragent|null $customer
 * @property Contragent $supplier
 * @property Collection|SupplyProduct[] $products
 * @property Contract $contract
 * @property int $contract_id
 * @property int $status_id
 * @property SupplyStatus $status
 * @property Collection|SupplyStatusTransitionRule $availableTransitionRules
 *
 * @mixin Builder
 */
class Supply extends Model
{
    use WithModifier;
    use WithSupplierAndCustomer;
    use WithOrderNumber;

    public const ORDER_NUMBER_TYPE = VariableDefinition::SUPPLY_ORDER_NUMBER;

    public const TABLE = 'supplies';

    public const FIELD_CUSTOMER_ID = 'customer_id';
    public const FIELD_EXECUTE_DATE = 'execute_date';
    public const FIELD_PLANNED_DATE = 'planned_date';
    public const FIELD_SUPPLIER_ID = 'supplier_id';
    public const FIELD_CONTRACT_ID = 'contract_id';
    public const FIELD_STATUS_ID = 'status_id';

    public const RELATION_CUSTOMER = 'customer';
    public const RELATION_SUPPLIER = 'customer';
    public const RELATION_PRODUCTS = 'products';
    public const RELATION_STATUS = 'status';
    public const RELATION_AVAILABLE_TRANSITION_RULES = 'availableTransitionRules';

    protected $fillable = [
        self::FIELD_EXECUTE_DATE,
        self::FIELD_PLANNED_DATE,
        self::FIELD_EXECUTE_DATE,
        self::FIELD_SUPPLIER_ID,
        self::FIELD_CONTRACT_ID,
        self::FIELD_CUSTOMER_ID,
        self::FIELD_STATUS_ID,
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(SupplyProduct::class);
    }

    /**
     * @return HasMany
     */
    public function scoreForPayments(): HasMany
    {
        return $this->hasMany(ScoreForPayment::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(SupplyStatus::class);
    }

    public function availableTransitionRules(): HasMany
    {
        return $this
            ->hasMany(
                SupplyStatusTransitionRule::class,
                SupplyStatusTransitionRule::FIELD_FROM_STATUS_ID,
                static::FIELD_STATUS_ID
            );
    }
}
