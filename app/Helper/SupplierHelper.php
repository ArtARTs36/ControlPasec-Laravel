<?php

namespace App\Helper;

use App\Models\Contragent;

class SupplierHelper
{
    /** @var Contragent */
    private $supplier;

    /** @var Contragent\MyContragent */
    private $myContragent;

    public function __construct(Contragent $supplier)
    {
        $this->supplier = $supplier;

        $this->myContragent = Contragent\MyContragent::where('contragent_id', $supplier->id)
            ->get()
            ->first();
    }

    public function getSignature(): string
    {
        return $this->myContragent ? $this->myContragent->signature : $this->supplier->title;
    }
}
