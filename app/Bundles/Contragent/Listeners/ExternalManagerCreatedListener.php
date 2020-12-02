<?php

namespace App\Bundles\Contragent\Listeners;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Vocab\Services\WordService;

final class ExternalManagerCreatedListener
{
    private $wordService;

    public function __construct(WordService $wordService)
    {
        $this->wordService = $wordService;
    }

    public function handle(ExternalManagerCreated $event): void
    {
        $manager = $event->manager();

        $this->wordService->getOrCreateByNominatives([
            $manager->name,
            $manager->patronymic,
            $manager->family,
        ]);
    }
}
