<?php

namespace App\Bundles\Contragent\Repositories;

use App\Based\Contracts\Repository;
use App\Bundles\Contragent\Models\MyContragent;

class MyContragentRepository extends Repository
{
    public function findByContragent(int $id): ?MyContragent
    {
        return $this->newQuery()
            ->where(MyContragent::FIELD_CONTRAGENT_ID, $id)
            ->first();
    }
}
