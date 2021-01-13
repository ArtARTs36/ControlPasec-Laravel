<?php

namespace App\Bundles\Cron\Contracts;

interface Supervisor
{
    public function update(): void;

    public function start(): void;
}
