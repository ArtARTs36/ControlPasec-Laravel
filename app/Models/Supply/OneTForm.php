<?php

namespace App\Models\Supply;

use App\Interfaces\ModelWithDocuments;
use App\Models\Document\Document;
use App\Models\Traits\WithDocuments;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupply;
use App\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class OneTForm
 * @property int id
 * @property int order_number
 * @property Document[] documents
 * @property int supply_id
 * @property Supply supply
 *
 * @mixin Builder
 */
class OneTForm extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    const ORDER_NUMBER_TYPE = VariableDefinition::ONE_T_FORM_ORDER_NUMBER;
}
