<?php

namespace App\Bundles\Admin\Support;

use App\Bundles\Admin\Repositories\AdminServiceRepository;

class Accessor
{
    protected $repository;

    public function __construct(AdminServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function allowed(string $name, string $ip): bool
    {
        return $this->repository->findOrFail($name)->access()->isAllowed($ip);
    }
}
