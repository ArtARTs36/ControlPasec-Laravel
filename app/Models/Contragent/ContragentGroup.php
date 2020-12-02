<?php

namespace App\Models\Contragent;

use App\Bundles\Contragent\Models\Contragent;
use Creatortsv\EloquentPipelinesModifier\WithModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

/**
 * Class ContragentGroup
 *
 * @property int $id
 * @property string $name
 * @property Contragent[] $contragents
 *
 * @mixin Builder
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
     * @return BelongsToMany
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

    /**
     * @param string $name
     * @return ContragentGroup
     */
    public static function createByName(string $name): ContragentGroup
    {
        return static::query()->create([
            self::FIELD_NAME => $name,
        ]);
    }
}
