<?php

namespace App\Based\Support\CSV;

class CSVResource
{
    public $strings;

    public $keys;

    /**
     * @param CSVString[] $strings
     * @param int[] $keys
     */
    public function __construct(array $strings, array $keys)
    {
        $this->strings = $strings;

        $this->keys = $keys;
    }
}
