<?php

namespace Tests\Bundles\Contragent\Generators;

use App\Bundles\Contragent\Models\BankRequisites;
use App\Bundles\Contragent\Models\Contragent;

class ContragentGenerator
{
    public static function gen(): Contragent
    {
        /** @var Contragent $contragent */
        $contragent = factory(Contragent::class)->create();

        factory(BankRequisites::class)->create([
            BankRequisites::FIELD_CONTRAGENT_ID => $contragent->id,
        ]);

        return $contragent;
    }
}
