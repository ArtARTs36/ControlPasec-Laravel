<?php

namespace App\Bundles\Vocab\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Support\Collection;

class VocabWordRepository extends Repository
{
    /**
     * @param array<string> $words
     */
    public function getByNominatives(array $words): Collection
    {
        return $this->newQuery()->whereIn(VocabWord::FIELD_NOMINATIVE, $words)->get();
    }
}
