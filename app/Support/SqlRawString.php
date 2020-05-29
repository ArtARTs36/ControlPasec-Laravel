<?php

namespace App\Support;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

class SqlRawString
{
    /**
     * @param string $field
     * @return Expression
     */
    public static function lower(string $field): Expression
    {
        return DB::raw("LOWER({$field})");
    }

    public static function lowerValue($value): Expression
    {
        return DB::raw("LOWER('{$value}')");
    }

    public static function byLowerAndLike(string $field, $value)
    {
        return [
            static::lower($field),
            'like',
            static::lowerValue(static::prepareValueToLike($value)),
        ];
    }

    public static function prepareValueToLike($value)
    {
        return '%'. mb_strtolower($value) . '%';
    }
}
