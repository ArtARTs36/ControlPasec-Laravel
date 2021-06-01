<?php

namespace App\Bundles\Supply\Events;

use App\Bundles\Supply\Models\Supply;
use App\User;

class SupplyCreated
{
    public $supply;

    public $creator;

    public function __construct(Supply $supply, User $creator)
    {
        $this->supply = $supply;
        $this->creator = $creator;
    }
}
