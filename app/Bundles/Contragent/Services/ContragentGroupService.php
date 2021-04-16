<?php

namespace App\Bundles\Contragent\Services;

use App\Bundles\Contragent\Models\ContragentGroup;
use App\Bundles\Contragent\Repositories\ContragentGroupRepository;

class ContragentGroupService
{
    protected $groups;

    public function __construct(ContragentGroupRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param array<int> $contragents
     */
    public function create(string $name, array $contragents): ContragentGroup
    {
        $group = $this->groups->createByName($name);
        $group->contragents()->attach($contragents);

        return $group;
    }
}
