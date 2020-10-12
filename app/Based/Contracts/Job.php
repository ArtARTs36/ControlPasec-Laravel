<?php

namespace App\Based\Contracts;

/**
 * Interface JobInterface
 * @package App\Based\Interfaces
 */
interface Job
{
    public function handle(): void;
}
