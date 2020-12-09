<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property string $short_name
 * @property string $full_name
 * @property int $bik
 * @property int $score
 *
 * @mixin Builder
 */
final class VocabBank extends Model
{
    protected $fillable = [
        'short_name', 'full_name', 'bik', 'score'
    ];
}
