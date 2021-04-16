<?php

namespace App\Bundles\Contragent\Models;

use App\Bundles\Supply\Models\Contract;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Модель "Контрагент"
 *
 * @property int $id
 * @property string $title
 * @property string|null $full_title
 * @property string|null $full_title_with_opf
 * @property integer|null $inn
 * @property int $kpp
 * @property integer|null $ogrn
 * @property integer|null $okato
 * @property integer|null $oktmo
 * @property string|null $okved
 * @property string|null $okved_type
 * @property string|null $address
 * @property string|null $address_postal
 * @property int $status
 * @property Collection<BankRequisites> $requisites
 * @property ContragentGroup[] $groups
 * @property Contract[] $contracts
 * @property string $title_for_document
 * @property Collection<ContragentManager> $managers
 *
 * @mixin Builder
 */
class Contragent extends Model
{
    use WithModifier;

    public const TABLE = 'contragents';

    public const FIELD_TITLE = 'title';
    public const FIELD_FULL_TITLE = 'full_title';
    public const FIELD_FULL_TITLE_WITH_OPF = 'full_title_with_opf';
    public const FIELD_KPP = 'kpp';
    public const FIELD_INN = 'inn';
    public const FIELD_OGRN = 'ogrn';
    public const FIELD_OKATO = 'okato';
    public const FIELD_OKTMO = 'oktmo';
    public const FIELD_OKVED = 'okved';
    public const FIELD_OKVED_TYPE = 'okved_type';
    public const FIELD_ADDRESS = 'address';
    public const FIELD_ADDRESS_POSTAL = 'address_postal';
    public const FIELD_STATUS = 'status';
    public const FIELD_TITLE_FOR_DOCUMENT = 'title_for_document';

    public const RELATION_CONTRACTS = 'contracts';
    public const RELATION_MANAGERS = 'managers';
    public const RELATION_REQUISITES = 'requisites';

    protected $fillable = [
        self::FIELD_TITLE,
        self::FIELD_FULL_TITLE,
        self::FIELD_FULL_TITLE_WITH_OPF,
        self::FIELD_OGRN,
        self::FIELD_OKATO,
        self::FIELD_OKTMO,
        self::FIELD_OKVED,
        self::FIELD_OKVED_TYPE,
        self::FIELD_ADDRESS,
        self::FIELD_ADDRESS_POSTAL,
        self::FIELD_STATUS,
        self::FIELD_INN,
        self::FIELD_OGRN,
        self::FIELD_KPP,
    ];

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

    /**
     * @codeCoverageIgnore
     */
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
        return $this->requisites->first();
    }

    /**
     * Получить название для документа
     * @return string
     */
    public function getTitleForDocument(): string
    {
        return $this->title_for_document ?? $this->title;
    }

    public function getInnOrOgrn(): int
    {
        return $this->inn ?? $this->ogrn;
    }
}
