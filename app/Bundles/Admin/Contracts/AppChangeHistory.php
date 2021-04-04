<?php

namespace App\Bundles\Admin\Contracts;

use App\Bundles\Admin\Entities\AppChange;

interface AppChangeHistory
{
    /**
     * @return array<AppChange>
     */
    public function all(): array;
}
