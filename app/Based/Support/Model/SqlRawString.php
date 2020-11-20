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

    /**
     * @param string $value
     * @return Expression
     */
    public static function lowerValue($value): Expression
    {
        return DB::raw("LOWER('{$value}')");
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return array
     */
    public static function byLowerAndLike(string $field, $value): array
    {
        return [
            static::lower($field),
            'like',
            static::lowerValue(static::prepareValueToLike($value)),
        ];
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function prepareValueToLike($value): string
    {
        return '%'. mb_strtolower($value) . '%';
    }
}
