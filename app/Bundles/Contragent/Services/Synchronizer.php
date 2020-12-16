<?php

namespace App\Bundles\Contragent\Services;

use App\Based\Models\ExternalSystem;
use App\Based\Models\ExternalSystemExchange;
use App\Based\Repositories\ExternalSystemRepository;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Support\Finder;
use App\Based\Services\ExternalExchanger;

class Synchronizer
{
    protected $finder;

    protected $synchronizer;

    protected $systemRepository;

    public function __construct(
        Finder $finder,
        ExternalExchanger $synchronizer,
        ExternalSystemRepository $systemRepository
    ) {
        $this->finder = $finder;
        $this->synchronizer = $synchronizer;
        $this->systemRepository = $systemRepository;
    }

    public function exchange(Contragent $contragent): ExternalSystemExchange
    {
        $response = $this->finder->findByInnOrOgrn($contragent->getInnOrOgrn(), false);

        return $this->synchronizer->create(
            $contragent,
            $this->systemRepository->findBySlug(ExternalSystem::SLUG_CONTRAGENT_DADATA),
            $response
        );
    }
}
