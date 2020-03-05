<?php

namespace App\Models;

use App\ContragentManager;
use App\Models\Contragent\BankRequisites;
use App\Models\Contragent\ContragentGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Contragent
 *
 * @property int id
 * @property string title
 * @property string|null full_title
 * @property string|null full_title_with_opf
 * @property integer|null inn
 * @property integer|null kpp
 * @property mixed|null ogrn
 * @property integer|null okato
 * @property integer|null oktmo
 * @property mixed|null okved
 * @property mixed|null okved_type
 * @property string|null address
 * @property string|null address_postal
 * @property int status
 * @property BankRequisites requisites
 * @property ContragentGroup[] groups
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

    public function managers()
    {
        return $this->hasMany(ContragentManager::class, 'contragent_id');
    }

    public function requisites()
    {
        return $this->hasMany(BankRequisites::class);
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
    public function getDefaultRequisite()
    {
        return $this->requisites[0] ?? null;
    }

    public function getTitleForDocument()
    {
        return $this->title_for_document ?? $this->title;
    }
}
