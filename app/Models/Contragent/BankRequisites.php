<?php

namespace App\Models\Contragent;

use App\Models\Vocab\VocabBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class BankRequisites
 *
 * @property string score
 * @property int contragent_id
 * @property int bank_id
 * @property VocabBank bank
 *
 * @mixin Builder
 */
class BankRequisites extends Model
{
    const PSEUDO = 'requisites';

    protected $fillable = [
        'score'
    ];

    public function bank()
    {
        return $this->belongsTo(VocabBank::class);
    }
}
