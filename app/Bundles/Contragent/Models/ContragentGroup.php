<?php

namespace App\Bundles\Contragent\Models;

use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class ContragentGroup
 *
 * @property int $id
 * @property string $name
 * @property Contragent[] $contragents
 */
final class ContragentGroup extends Model
{
    use WithModifier;

    public const FIELD_NAME = 'name';

    public const RELATION_CONTRAGENTS = 'contragents';

    protected $fillable = [
        self::FIELD_NAME,
    ];

    /**
     * @codeCoverageIgnore
     */
    public function contragents(): BelongsToMany
    {
        return $this->belongsToMany(
            Contragent::class,
            'contragent_group_related',
            'group_id',
            'contragent_id'
        );
    }
}
