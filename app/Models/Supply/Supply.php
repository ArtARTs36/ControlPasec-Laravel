<?php

namespace App\Models\Supply;

use App\Models\Contract\Contract;
use App\Models\Contragent;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Supply
 *
 * Модель "поставка"
 *
 * @property integer id
 * @property string planned_date
 * @property string execute_date
 * @property int supplier_id
 * @property int customer_id
 * @property Contragent customer
 * @property Contragent supplier
 * @property SupplyProduct[] products
 * @property Contract contract
 * @property int contract_id
 *
 * @mixin Builder
 */
class Supply extends Model
{
    protected $fillable = [
        'planned_date', 'execute_date', 'supplier_id', 'customer_id', 'contract_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(SupplyProduct::class);
    }

    public function customer()
    {
        return $this->belongsTo(Contragent::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Contragent::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
