<?php

namespace App\Models\Contract;

use App\Models\Contragent;
use App\Models\Supply\Supply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Contract
 *
 * @property integer supplier_id
 * @property integer customer_id
 */
class Contract extends Model
{
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
