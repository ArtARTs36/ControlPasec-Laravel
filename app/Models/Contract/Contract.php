<?php

namespace App\Models\Contract;

use App\Models\Contragent;
use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Model;
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
 *
 * @mixin Builder
 */
class Contract extends Model
{
    protected $fillable = [
        'title', 'planned_date', 'executed_date', 'supplier_id', 'customer_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Contragent::class);
    }

    public function customer()
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Поставки по договору
     *
     * @return HasMany|Supply[]
     */
    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
