<?php

namespace App\Models;

use App\Models\Product\Product;
use App\Models\Traits\WithModelType;
use App\Models\Vocab\VocabCurrency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class VariableDefinition
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $description
 * @property bool $is_take_of_parent
 * @property ModelType $modelType
 * @property ModelType|null $model_type_id
 *
 * @mixin Builder
 */
final class VariableDefinition extends Model
{
    use WithModelType;

    const PRODUCT_ID = 'product_id';
    const SUPPLY_ORDER_NUMBER = 'supply_order_number';
    const SCORE_FOR_PAYMENT_ORDER_NUMBER = 'score_for_payment_order_number';
    const ONE_T_FORM_ORDER_NUMBER = 'one_t_form_order_number';
    const QUALITY_CERTIFICATE_ORDER_NUMBER = 'quality_certificate_order_number';

    protected $fillable = [
        'value',
    ];

    /**
     * @return mixed
     */
    public function getModel(): Model
    {
        $class = $this->modelType->class;

        return $class::find($this->value);
    }
}
