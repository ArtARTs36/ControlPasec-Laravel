<?php

namespace App\Bundles\Supply\Models;

use App\Based\Contracts\ModelWithDocuments;
use App\Bundles\Document\Models\Document;
use App\Bundles\Document\Models\DocumentType;
use App\Bundles\Document\Support\WithDocuments;
use App\Based\ModelSupport\WithOrderNumber;
use App\Bundles\Supply\Support\WithSupply;
use App\Bundles\Admin\Models\VariableDefinition;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property integer $supply_id
 * @property integer $contract_id
 * @property string $date
 * @property Supply $supply
 * @property int $order_number
 */
final class ScoreForPayment extends Model implements ModelWithDocuments
{
    use WithDocuments, WithOrderNumber, WithSupply, WithModifier;

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

    /**
     * @codeCoverageIgnore
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
