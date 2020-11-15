<?php

namespace App\Bundles\Vocab\Models;

use App\Helper\ModelPrioritiesRefresher\ModelWithPriorityInterface;
use App\Helper\ModelPrioritiesRefresher\WithPriority;
use App\Scopes\PriorityScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabCurrency
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $name_en
 * @property string $short_name_en
 * @property int $iso_code
 * @property string $iso_short_name
 * @property string $symbol
 * @property int $priority
 *
 * @mixin Builder
 */
final class VocabCurrency extends Model implements ModelWithPriorityInterface
{
    use WithPriority;

    public const ISO_RUB = 'RUB';

    public const FIELD_ID = 'id';
    public const FIELD_NAME = 'name';
    public const FIELD_SHORT_NAME = 'short_name';
    public const FIELD_NAME_EN = 'name_en';
    public const FIELD_SHORT_NAME_EN = 'short_name_en';
    public const FIELD_ISO_CODE = 'iso_code';
    public const FIELD_SYMBOL = 'symbol';
    public const FIELD_ISO_SHORT_NAME = 'iso_short_name';
    public const FIELD_PRIORITY = 'priority';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NAME,
        self::FIELD_SHORT_NAME,
        self::FIELD_NAME_EN,
        self::FIELD_SHORT_NAME,
        self::FIELD_SHORT_NAME_EN,
        self::FIELD_ISO_CODE,
        self::FIELD_SYMBOL,
        self::FIELD_ISO_SHORT_NAME,
        self::FIELD_PRIORITY,
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new PriorityScope());
    }
}
