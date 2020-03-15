<?php

namespace App\Models\Supply;

use App\Models\Document\Document;
use App\Models\Traits\WithDocuments;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

/**
 * Class ProductTransportWaybill
 *
 * Товарно-транспортная накладная - ТОРГ 12
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
    use WithDocuments, WithOrderNumber, WithSupply;

    protected $fillable = [
        'order_number', 'date', 'supply_id'
    ];
}
