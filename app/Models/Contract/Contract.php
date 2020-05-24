<?php

namespace App\Models\Contract;

use App\Models\Contragent;
use App\Models\Supply\Supply;
use App\Models\Traits\WithSupplierAndCustomer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * Class Contract
 *
 * @property int $id
 * @property string $title
 * @property string $planned_date
 * @property string $executed_date
 * @property int $supplier_id
 * @property int $customer_id
 * @property int $template_id
 * @property ContractTemplate $template
 *
 * @mixin Builder
 */
class Contract extends Model
{
    use WithSupplierAndCustomer;

    public const FIELD_CUSTOMER_ID = 'customer_id';

    public const RELATION_CUSTOMER = 'customer';
    public const RELATION_SUPPLIER = 'supplier';
    public const RELATION_TEMPLATE = 'template';
    public const RELATION_SUPPLIES = 'supplies';

    protected $fillable = [
        'title', 'planned_date', 'executed_date', 'supplier_id', 'template_id',
        self::FIELD_CUSTOMER_ID,
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(ContractTemplate::class);
    }

    /**
     * Поставки по договору
     *
     * @return HasMany
     */
    public function supplies(): HasMany
    {
        return $this->hasMany(Supply::class);
    }
}
