<?php

namespace App\Bundles\Contragent\Listeners;

use App\Bundles\Vocab\Services\WordService;
use App\Models\Contragent\ContragentManager;

final class ExternalManagerCreatedListener
{
    private $wordService;

    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    public function handle(ContragentManager $manager): void
    {
        $this->wordService->getOrCreateByNominatives([
            $manager->name,
            $manager->patronymic,
            $manager->family,
        ]);
    }
}
