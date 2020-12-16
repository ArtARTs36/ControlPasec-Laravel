<?php

namespace App\Bundles\Vocab\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @property string $short_name
 * @property string $full_name
 * @property int $bik
 * @property int $score
 */
final class VocabBank extends Model
{
    public const FIELD_SHORT_NAME = 'short_name';
    public const FIELD_FULL_NAME = 'full_name';
    public const FIELD_BIK = 'bik';
    public const FIELD_SCORE = 'score';

    protected $fillable = [
        self::FIELD_SHORT_NAME,
        self::FIELD_FULL_NAME,
        self::FIELD_BIK,
        self::FIELD_SCORE,
    ];
}
