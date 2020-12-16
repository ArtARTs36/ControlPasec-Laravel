<?php

namespace App\Bundles\User\Contracts;

interface Tokenizer
{
    public function getTokenTtl(string $token): int;
}
