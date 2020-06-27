<?php

namespace App\Models\Supply;

use App\Models\Contract\Contract;
use App\Models\Contragent;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupplierAndCustomer;
use App\Models\VariableDefinition;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * Class Supply
 *
 * Модель "поставка"
 *
 * @property integer $id
 * @property string|\DateTime $planned_date
 * @property string|\DateTime $execute_date
 * @property int $supplier_id
 * @property int $customer_id
 * @property Contragent $customer
 * @property Contragent $supplier
 * @property Collection|SupplyProduct[] $products
 * @property Contract $contract
 * @property int $contract_id
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

    public const RELATION_CUSTOMER = 'customer';
    public const RELATION_SUPPLIER = 'customer';
    public const RELATION_PRODUCTS = 'products';

    protected $fillable = [
        self::FIELD_EXECUTE_DATE,
        self::FIELD_PLANNED_DATE,
        self::FIELD_EXECUTE_DATE,
        self::FIELD_SUPPLIER_ID,
        self::FIELD_CONTRACT_ID,
        self::FIELD_CUSTOMER_ID,
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
}
