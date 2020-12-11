<?php

namespace App\Models\Supply;

use App\Based\Interfaces\ModelWithDocuments;
use App\Based\ModelSupport\WithFillOfRequest;
use App\Models\Document\DocumentType;
use App\Models\Traits\WithDocuments;
use App\Based\ModelSupport\WithOrderNumber;
use App\Bundles\Supply\Support\WithSupply;
use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
 * Товарно-транспортная накладная - ТОРГ 12
 * @property int $id
 * @property int $order_number
 * @property string $date
 * @property int $supply_id
 * @property Supply $supply
 */
final class ProductTransportWaybill extends Model implements ModelWithDocuments
{
    use WithDocuments;
    use WithOrderNumber;
    use WithSupply;
    use WithFillOfRequest;

    public const TARGET_TYPE = DocumentType::TORG_12_ID;

    public const ORDER_NUMBER_TYPE = VariableDefinition::TORG_12_ORDER_NUMBER;

    public const FIELD_ID = 'id';
    public const FIELD_ORDER_NUMBER = 'order_number';
    public const FIELD_DATE = 'date';
    public const FIELD_SUPPLY_ID = 'supply_id';

    protected $fillable = [
        self::FIELD_ORDER_NUMBER,
        self::FIELD_DATE,
        self::FIELD_SUPPLY_ID,
    ];
}
