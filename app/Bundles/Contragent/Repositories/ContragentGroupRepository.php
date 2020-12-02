<?php

namespace App\Bundles\Contragent\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Contragent\Models\ContragentGroup;

final class ContragentGroupRepository extends Repository
{
    public function createByName(string $name): ContragentGroup
    {
        return $this->newQuery()->create([
            ContragentGroup::FIELD_NAME => $name,
        ]);
    }
}
