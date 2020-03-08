<?php

namespace App\Models;

use App\Models\Contragent\ContragentManager;
use App\Models\Contract\Contract;
use App\Models\Contragent\BankRequisites;
use App\Models\Contragent\ContragentGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Contragent
 *
 * @property int id
 * @property string title
 * @property string|null full_title
 * @property string|null full_title_with_opf
 * @property integer|null inn
 * @property integer|null kpp
 * @property integer|null ogrn
 * @property integer|null okato
 * @property integer|null oktmo
 * @property string|null okved
 * @property string|null okved_type
 * @property string|null address
 * @property string|null address_postal
 * @property int status
 * @property BankRequisites requisites
 * @property ContragentGroup[] groups
 * @property Contract[] contracts
 *
 * @mixin Builder
 */
class Contragent extends Model
{
    const TABLE = 'contragents';

    protected $fillable = [
        'title', 'full_title', 'full_title_with_opf',
        'inn', 'kpp', 'ogrn', 'okato', 'oktmo', 'okved', 'okved_type',
        'address', 'address_postal'
    ];

    /**
     * @return HasMany
     */
    public function managers(): HasMany
    {
        return $this->hasMany(ContragentManager::class, 'contragent_id');
    }

    /**
     * @return HasMany
     */
    public function requisites(): HasMany
    {
        return $this->hasMany(BankRequisites::class);
    }

    /**
     * @return HasMany
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'customer_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            ContragentGroup::class,
            'contragent_group_related',
            'contragent_id',
            'group_id'
        );
    }

    /**
     * @return BankRequisites
     */
    public function getDefaultRequisite(): BankRequisites
    {
        return $this->requisites[0] ?? null;
    }

    /**
     * Получить название для документа
     * @return string
     */
    public function getTitleForDocument(): string
    {
        return $this->title_for_document ?? $this->title;
    }
}
