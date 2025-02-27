<?php

namespace App\Bundles\Contragent\Support;

use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Repositories\MyContragentRepository;

class TextSignature
{
    protected $repository;

    protected $container;

    public function __construct(MyContragentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(Contragent $contragent): string
    {
        if ($this->notHas($contragent) && ($myContragent = $this->repository->findByContragent($contragent->id))) {
            return $this->container[$contragent->id] = $myContragent->signature;
        }

        return $contragent->title_for_document;
    }

    protected function notHas(Contragent $contragent): bool
    {
        return empty($this->container[$contragent->id]);
    }
}
