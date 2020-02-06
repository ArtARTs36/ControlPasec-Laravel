<?php

namespace App\Models\Contragent;

use App\Models\Vocab\VocabBank;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BankRequisites
 *
 * @property string score
 * @property int contragent_id
 * @property int bank_id
 */
class BankRequisites extends Model
{
    const PSEUDO = 'requisites';

    public function bank()
    {
        return $this->belongsTo(VocabBank::class);
    }
}
