<?php

namespace App\Based\Support\Query;

class LowerValue extends LowerField
{
    protected function preparedValue($value): string
    {
        return "LOWER('{$value}')";
    }
}
