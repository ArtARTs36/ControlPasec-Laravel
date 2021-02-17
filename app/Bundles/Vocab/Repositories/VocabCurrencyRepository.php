<?php

namespace App\Bundles\Vocab\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Vocab\Models\VocabCurrency;
use Illuminate\Support\Collection;

class VocabCurrencyRepository extends Repository
{
    public function getWithoutCurrency(string $name): Collection
    {
        return $this
            ->newQuery()
            ->where(VocabCurrency::FIELD_ISO_SHORT_NAME, '!=', $name)
            ->get();
    }
}
