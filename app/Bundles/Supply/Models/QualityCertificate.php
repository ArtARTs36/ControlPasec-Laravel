<?php

namespace App\Bundles\Supply\Models;

use App\Based\Contracts\ModelWithDocuments;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Document\Support\WithDocuments;
use App\Based\ModelSupport\WithOrderNumber;
use App\Bundles\Supply\Support\WithSupply;
use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
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
