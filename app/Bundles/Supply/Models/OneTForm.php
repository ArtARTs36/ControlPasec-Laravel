<?php

namespace App\Bundles\Supply\Models;

use App\Based\Contracts\ModelWithDocuments;
use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Document\Support\WithDocuments;
use App\Based\ModelSupport\WithOrderNumber;
use App\Bundles\Supply\Support\WithSupply;
use App\Bundles\Admin\Models\VariableDefinition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property int $order_number
 * @property int $supply_id
 * @property Supply $supply
 *
 * @mixin Builder
 */
final class OneTForm extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    public const FIELD_ORDER_NUMBER = 'order_number';
    public const FIELD_SUPPLY_ID = 'supply_id';

    const ORDER_NUMBER_TYPE = VariableDefinition::ONE_T_FORM_ORDER_NUMBER;
    const TARGET_TYPE = DocumentType::ONE_T_FORM_ID;
}
