<?php

namespace App\Helper;

use App\Models\Contragent;

class SupplierHelper
{
    /** @var Contragent */
    private $supplier;

    private $myContragent;

    public function __construct($supplier)
    {
        $this->supplier = $supplier;

        $this->myContragent = Contragent\MyContragent::where('contragent_id', $supplier->id)
            ->get()
            ->first();
    }

    public function getSignature()
    {
        return $this->myContragent ? $this->myContragent->signature : $this->supplier->title;
    }
}
