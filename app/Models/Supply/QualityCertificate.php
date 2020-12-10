<?php

namespace App\Models\Supply;

use App\Based\Interfaces\ModelWithDocuments;
use App\Models\Document\DocumentType;
use App\Models\Traits\WithDocuments;
use App\Based\ModelSupport\WithOrderNumber;
use App\Models\Traits\WithSupply;
use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QualityCertificate
 * @property int $id
 * @property int $order_number
 * @property int $supply_id
 * @property Supply $supply
 */
class QualityCertificate extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    public const FIELD_ORDER_NUMBER = 'order_number';
    public const FIELD_SUPPLY_ID = 'supply_id';

    public const TARGET_TYPE = DocumentType::QUALITY_CERTIFICATE_ID;
    public const ORDER_NUMBER_TYPE = VariableDefinition::QUALITY_CERTIFICATE_ORDER_NUMBER;
}
