<?php

namespace App\Models\Contragent;

use App\Bundles\Vocab\Models\VocabBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * Class BankRequisites
 *
 * @property int $id
 * @property string $score
 * @property int $contragent_id
 * @property int $bank_id
 * @property VocabBank $bank
 *
 * @mixin Builder
 */
final class BankRequisites extends Model
{
    const PSEUDO = 'requisites';

    protected $fillable = [
        'score'
    ];

    /**
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(VocabBank::class);
    }
}
