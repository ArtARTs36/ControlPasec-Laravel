<?php

namespace App\Helper\CSVHelper;

class CSVResource
{
    /**
     * @var CSVString[]
     */
    public $strings;

    /**
     * @var string|int[]
     */
    public $keys;

    public function __construct($strings, $keys)
    {
        $this->strings = $strings;

        $this->keys = $keys;
    }

    public function getValue($key, $defaultValue = '')
    {
        return $this->$key ?? $defaultValue;
    }
}
