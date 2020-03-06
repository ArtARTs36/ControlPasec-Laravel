<?php

namespace App\Models\Vocab;

use App\Helper\ModelPrioritiesRefresher\ModelWithPriorityInterface;
use App\Helper\ModelPrioritiesRefresher\WithPriority;
use App\Scopes\PriorityScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class VocabCurrency
 *
 * @property int id
 * @property string name
 * @property string short_name
 * @property string name_en
 * @property string short_name_en
 * @property int iso_code
 * @property int iso_short_name
 * @property string symbol
 * @property int priority
 *
 * @mixin Builder
 */
final class VocabCurrency extends Model implements ModelWithPriorityInterface
{
    use WithPriority;

    protected $fillable = [
        'id', 'name', 'short_name', 'name_en', 'short_name_en', 'iso_code', 'iso_short_name', 'symbol'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(new PriorityScope());
    }
}
