<?php

namespace App;

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

    const ORDER_NUMBER_TYPE = VariableDefinition::SCORE_FOR_PAYMENT_ORDER_NUMBER;
    const TARGET_TYPE = DocumentType::SCORE_FOR_PAYMENT_ID;

    const FIELD_SUPPLY_ID = 'supply_id';

    protected $fillable = [
        'supply_id', 'contract_id', 'date'
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = []): bool
    {
        $this->initOrderNumber();

        return parent::save($options);
    }
}
