<?php

namespace App\Bundles\Contragent\Events;

use App\Bundles\Contragent\Models\ContragentManager;

final class ExternalManagerCreated
{
    private $manager;

    public function __construct(ContragentManager $manager)
    {
        $this->manager = $manager;
    }

    public function manager(): ContragentManager
    {
        return $this->manager;
    }
}
