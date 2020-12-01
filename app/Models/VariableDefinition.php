<?php

namespace App\Models;

use App\Models\Traits\WithModelType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VariableDefinition
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $description
 * @property bool $is_take_of_parent
 * @property ModelType|null $modelType
 * @property int|null $model_type_id
 *
 * @mixin Builder
 */
final class VariableDefinition extends Model
{
    use WithModelType;

    public const PRODUCT_ORDER_NUMBER = 'product_order_number';
    public const PRODUCT_ID = 'product_id';
    public const SUPPLY_ORDER_NUMBER = 'supply_order_number';
    public const SCORE_FOR_PAYMENT_ORDER_NUMBER = 'score_for_payment_order_number';
    public const ONE_T_FORM_ORDER_NUMBER = 'one_t_form_order_number';
    public const QUALITY_CERTIFICATE_ORDER_NUMBER = 'quality_certificate_order_number';
    public const TORG_12_ORDER_NUMBER = 'torg_12_order_number';

    public const FIELD_VALUE = 'value';

    protected $fillable = [
        self::FIELD_VALUE,
    ];

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        $class = $this->modelType->class;

        return $class::find($this->value);
    }
}
