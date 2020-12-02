<?php

namespace App\Helper;

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\MyContragent;

class SupplierHelper
{
    /** @var Contragent */
    private $supplier;

    private $myContragent;

    /** @var static[] */
    private static $instances;

    public function __construct(Contragent $supplier, MyContragent $myContragent)
    {
        $this->supplier = $supplier;
        $this->myContragent = $myContragent;
    }

    /**
     * Получить подпись
     * @return string
     */
    public function getSignature(): string
    {
        return $this->myContragent !== null ? $this->myContragent->signature : $this->supplier->title;
    }

    public static function getInstance(Contragent $supplier)
    {
        if (empty(static::$instances[$supplier->id])) {
            static::$instances[$supplier->id] = new static(
                $supplier,
                MyContragent::where('contragent_id', $supplier->id)
                    ->get()
                    ->first()
            );
        }

        return static::$instances[$supplier->id];
    }

    public static function getDefaultId(): int
    {
        return (int) env('ONE_SUPPLIER_ID');
    }
}
