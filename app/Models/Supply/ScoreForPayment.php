<?php

namespace App\Models\Supply;

use App\Interfaces\ModelWithDocuments;
use App\Models\Contract\Contract;
use App\Models\Document\Document;
use App\Models\Document\DocumentType;
use App\Models\Supply\Supply;
use App\Models\Traits\WithDocuments;
use App\Models\Traits\WithOrderNumber;
use App\Models\Traits\WithSupply;
use App\Models\VariableDefinition;
use App\Services\VariableDefinitionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

/**
 * Class ScoreForPayment
 *
 * @property int $id
 * @property integer $supply_id
 * @property integer $contract_id
 * @property string $date
 * @property Supply $supply
 * @property int $order_number
 * @property Document[] $documents
 *
 * @mixin Builder
 */
final class ScoreForPayment extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply;

    public const ORDER_NUMBER_TYPE = VariableDefinition::SCORE_FOR_PAYMENT_ORDER_NUMBER;
    public const TARGET_TYPE = DocumentType::SCORE_FOR_PAYMENT_ID;

    public const FIELD_SUPPLY_ID = 'supply_id';
    public const FIELD_CONTRACT_ID = 'contract_id';
    public const FIELD_DATE = 'date';
    public const FIELD_ORDER_NUMBER = 'order_number';

    public const RELATION_SUPPLY = 'supply';

    protected $fillable = [
        self::FIELD_SUPPLY_ID,
        self::FIELD_CONTRACT_ID,
        self::FIELD_DATE,
        self::FIELD_ORDER_NUMBER,
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public static function createBySupply(Supply $supply): ScoreForPayment
    {
        return static::query()->create([
            static::FIELD_SUPPLY_ID => $supply->id,
            static::FIELD_DATE => $supply->planned_date,
        ]);
    }
}
