<?php

namespace App\Bundles\Contragent\Support;

final class DaDataAccessKey
{
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function get(): string
    {
        return $this->key;
    }
}
