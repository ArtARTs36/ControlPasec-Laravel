<?php

namespace App\Models\Supply;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ProductTransportWaybill
 *
 * Товарно-транпспортная наклдная
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
class ProductTransportWaybill extends Model
{
    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function getDocument()
    {
        return $this->documents[0] ?? null;
    }
}
