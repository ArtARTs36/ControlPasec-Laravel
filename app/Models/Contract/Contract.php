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
 * @property int id
 * @property string title
 * @property string planned_date
 * @property string executed_date
 * @property int supplier_id
 * @property int customer_id
 * @property int template_id
 * @property ContractTemplate template
 *
 * @mixin Builder
 */
class Contract extends Model
{
    use WithSupplierAndCustomer;

    protected $fillable = [
        'title', 'planned_date', 'executed_date', 'supplier_id', 'customer_id', 'template_id'
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
