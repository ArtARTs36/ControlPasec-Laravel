<?php

namespace App\Based\Support\Query;

use Illuminate\Database\Query\Expression;

class LowerField extends Expression
{
    public function __construct($value)
    {
        parent::__construct($this->preparedValue($value));
    }

    protected function preparedValue($value): string
    {
        return "LOWER({$value})";
    }
}
