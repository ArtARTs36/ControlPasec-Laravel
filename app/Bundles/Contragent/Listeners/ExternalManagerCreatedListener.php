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
        $words = [$manager->name, $manager->patronymic, $manager->family,];

        if (! empty($manager->post)) {
            $words[] = $manager->post;
        }

        $this->wordService->getOrCreateByNominatives($words);
    }
}
