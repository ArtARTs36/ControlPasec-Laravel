<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Vocab\VocabCurrency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VariableDefinition
 *
 * @property int id
 * @property string name
 * @property string value
 * @property string description
 * @property bool is_take_of_parent
 * @property ModelType model_type
 * @property ModelType|null model_type_id
 *
 * @mixin Builder
 */
class VariableDefinition extends Model
{
    const PRODUCT_ID = 'product_id';
    const SUPPLY_ORDER_NUMBER = 'supply_order_number';
    const SCORE_FOR_PAYMENT_ORDER_NUMBER = 'score_for_payment_order_number';

    public function modelType()
    {
        return $this->belongsTo(ModelType::class);
    }

    public function getModel()
    {
        $class = $this->model_type->class;

        return $class::find($this->value);
    }
}
