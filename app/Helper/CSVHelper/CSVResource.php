<?php

namespace App\Helper\CSVHelper;

class CSVResource
{
    protected $strings;

    protected $keys;

    public function __construct(array $strings, array $keys)
    {
        $this->strings = $strings;

        $this->keys = $keys;
    }

    /**
     * @return CSVString[]
     */
    public function getStrings(): array
    {
        return $this->strings;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }
}
