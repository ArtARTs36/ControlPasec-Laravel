<?php

namespace App\Based\Support\Query;

class LowerValueLike extends LowerValue
{
    protected function preparedValue($value): string
    {
        return '\'%'. mb_strtolower($value) . '%\'';
    }
}
