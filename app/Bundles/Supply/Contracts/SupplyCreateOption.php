<?php

namespace App\Bundles\Supply\Contracts;

use App\Bundles\Supply\Models\Supply;

interface SupplyCreateOption
{
    public function handle(Supply $supply): void;
}
