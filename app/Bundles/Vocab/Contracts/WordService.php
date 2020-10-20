<?php

namespace App\Bundles\Vocab\Contracts;

use Illuminate\Support\Collection;

interface WordService
{
    public function getOrCreateByNominatives(array $words): Collection;

    public function getByNominatives(string ...$words): Collection;
}
