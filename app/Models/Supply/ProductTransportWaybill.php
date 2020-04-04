<?php

namespace App\Models\Supply;

use App\Interfaces\ModelWithDocuments;
use App\Models\Document\DocumentType;
use App\Models\Traits\WithDocuments;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupply;
use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class ProductTransportWaybill
 *
 * Товарно-транспортная накладная - ТОРГ 12
 *
 * @package App\Models\Supply
 *
 * @property int $id
 * @property int $order_number
 * @property string $date
 * @property int $supply_id
 * @property Supply $supply
 *
 * @mixin Builder
 */
final class ProductTransportWaybill extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    public const TARGET_TYPE = DocumentType::TORG_12_ID;

    public const ORDER_NUMBER_TYPE = VariableDefinition::TORG_12_ORDER_NUMBER;

    protected $fillable = [
        'order_number', 'date', 'supply_id'
    ];
}
