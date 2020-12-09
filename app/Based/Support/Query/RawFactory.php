<?php

namespace App\Based\Support\Query;

class RawFactory
{
    public static function byLowerAndLike(string $field, $value): array
    {
        return [
            new LowerField($field),
            'like',
            new LowerValueLike($value),
        ];
    }
}
