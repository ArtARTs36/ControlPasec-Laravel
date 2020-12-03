<?php

namespace App\Bundles\Supply\Contracts;

use App\Models\Supply\Supply;

interface SupplyCreateOption
{
    public function handle(Supply $supply): void;
}
