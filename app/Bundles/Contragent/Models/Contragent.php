<?php

namespace App\Models;

use App\Models\Contragent\ContragentManager;
use App\Models\Contract\Contract;
use App\Models\Contragent\BankRequisites;
use App\Models\Contragent\ContragentGroup;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель "Контрагент"
 *
 * @property int $id
 * @property string $title
 * @property string|null $full_title
 * @property string|null $full_title_with_opf
 * @property integer|null $inn
 * @property integer|null $kpp
 * @property integer|null $ogrn
 * @property integer|null $okato
 * @property integer|null $oktmo
 * @property string|null $okved
 * @property string|null $okved_type
 * @property string|null $address
 * @property string|null $address_postal
 * @property int $status
 * @property BankRequisites $requisites
 * @property ContragentGroup[] $groups
 * @property Contract[] $contracts
 * @property string $title_for_document
 *
 * @mixin Builder
 */
class Contragent extends Model
{
    use WithModifier;

    public const TABLE = 'contragents';

    public const RELATION_CONTRACTS = 'contracts';
    public const RELATION_REQUISITES = 'requisites';

    protected $fillable = [
        'title', 'full_title', 'full_title_with_opf',
        'ogrn', 'okato', 'oktmo', 'okved', 'okved_type',
        'address', 'address_postal',
        self::FIELD_INN,
        self::FIELD_OGRN,
    ];

    public const FIELD_INN = 'inn';
    public const FIELD_OGRN = 'ogrn';

    /**
     * @codeCoverageIgnore
     */
    public function managers(): HasMany
    {
        return $this->hasMany(ContragentManager::class, 'contragent_id');
    }

    /**
     * @codeCoverageIgnore
     */
    public function requisites(): HasMany
    {
        return $this->hasMany(BankRequisites::class);
    }

    /**
     * @codeCoverageIgnore
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

    public function getDefaultRequisite(): ?BankRequisites
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
