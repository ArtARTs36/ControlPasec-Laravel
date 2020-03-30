<?php

namespace App\Models\Supply;

use App\Interfaces\ModelWithDocuments;
use App\Models\Document\DocumentType;
use App\Models\Traits\WithDocuments;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupply;
use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QualityCertificate
 * @property int id
 * @property int order_number
 * @property int supply_id
 * @property Supply supply
 */
class QualityCertificate extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    const TARGET_TYPE = DocumentType::QUALITY_CERTIFICATE_ID;

    const ORDER_NUMBER_TYPE = VariableDefinition::QUALITY_CERTIFICATE_ORDER_NUMBER;
}
