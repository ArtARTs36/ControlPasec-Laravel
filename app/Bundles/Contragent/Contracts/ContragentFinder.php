<?php

namespace App\Bundles\Contragent\Contracts;

use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Support\Collection;

interface ContragentFinder
{
    /**
     * @return Collection|Contragent[]
     */
    public function findAndCreateByInnOrOgrn(string $slug): Collection;

    /**
     * @return Collection|Contragent[]
     */
    public function findByInnOrOgrn(string $slug): Collection;
}
