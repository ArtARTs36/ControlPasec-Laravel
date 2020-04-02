<?php

namespace App\Models\Supply;

use App\Models\Contract\Contract;
use App\Models\Contragent;
use App\Models\Traits\WithSupplierAndCustomer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

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
 * @property SupplyProduct[] $products
 * @property Contract $contract
 * @property int $contract_id
 *
 * @mixin Builder
 */
class Supply extends Model
{
    use WithSupplierAndCustomer;

    const TABLE = 'supplies';

    protected $fillable = [
        'planned_date', 'execute_date', 'supplier_id', 'customer_id', 'contract_id'
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(SupplyProduct::class);
    }

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
