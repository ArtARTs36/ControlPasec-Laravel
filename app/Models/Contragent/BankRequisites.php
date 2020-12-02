<?php

namespace App\Models\Contragent;

use App\Models\Contragent;
use App\Models\Vocab\VocabBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель "Банковские реквизиты"
 *
 * @property int $id
 * @property string $score
 * @property int $contragent_id
 * @property int $bank_id
 * @property VocabBank $bank
 */
final class BankRequisites extends Model
{
    const PSEUDO = 'requisites';

    public const FIELD_SCORE = 'score';

    protected $fillable = [
        self::FIELD_SCORE,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(VocabBank::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function contragent(): BelongsTo
    {
        return $this->belongsTo(Contragent::class);
    }
}
