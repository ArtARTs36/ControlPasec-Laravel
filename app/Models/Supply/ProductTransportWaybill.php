<?php

namespace App\Models\Supply;

use App\Models\Document\Document;
use App\Models\Traits\WithDocuments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

/**
 * Class ProductTransportWaybill
 *
 * Товарно-транспортная накладная
 *
 * @package App\Models\Supply
 *
 * @property int id
 * @property int order_number
 * @property string date
 * @property int supply_id
 * @property Supply supply
 *
 * @mixin Builder
 */
final class ProductTransportWaybill extends Model
{
    use WithDocuments;

    protected $fillable = [
        'order_number', 'date', 'supply_id'
    ];

    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
