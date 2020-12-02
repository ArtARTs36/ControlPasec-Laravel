<?php

namespace App\Bundles\Contragent\Support;

use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\ContragentManager;
use Illuminate\Support\Collection;

class Finder
{
    protected $managers;

    protected $client;

    public function __construct(DaDataClient $client)
    {
        $this->managers = collect();
        $this->client = $client;
    }

    public function findByInnOrOgrn($slug, bool $save = true): Collection
    {
        $contragents = collect();

        $responses = $this->client->findByInn($slug);

        foreach ($responses['suggestions'] as $response) {
            if (empty($response['data'])) {
                continue;
            }

            $response = $response['data'];

            $contragent = new Contragent();

            $this->fillContragent($contragent, $response);

            $save && $contragent->save();

            $contragents->push($contragent);

            if (! isset($response['management'])) {
                $this->createManager($contragent, $response);
            }
        }

        return $contragents;
    }

    protected function fillContragent(Contragent $contragent, array $response): Contragent
    {
        $contragent->title = $response['name']['short'] ?? $response['name']['short_with_opf'] ?? null;
        $contragent->full_title = $response['name']['full'] ?? null;
        $contragent->full_title_with_opf = $response['name']['full_with_opf'] ?? null;

        $contragent->inn = $response['inn'] ?? null;
        $contragent->kpp = $response['kpp'] ?? null;

        $contragent->ogrn = $response['ogrn'] ?? null;
        $contragent->okato = $response['address']['data']['okato'] ?? null;
        $contragent->oktmo = $response['address']['data']['oktmo'] ?? null;
        $contragent->okved = $response['okved'] ?? null;
        $contragent->okved_type = $response['okved_type'] ?? null;

        $contragent->address = $response['address']['value'];
        $contragent->address_postal = $response['address']['data']['postal_code'];
        $contragent->status = 0;

        return $contragent;
    }

    public function createManager(Contragent $contragent, array $response): ?ContragentManager
    {
        $manageString = explode(' ', $response['management']['name']);

        if (count($manageString) !== 3) {
            return null;
        }

        $manager = new ContragentManager();

        $manager->name = $manageString[1];
        $manager->patronymic = $manageString[2];
        $manager->family = $manageString[0];

        $words = [$manager->name, $manager->patronymic, $manager->family];

        if (! empty($response['management']['post'])) {
            $manager->post = $response['management']['post'];

            $words[] = $manager->post;
        }

        $manager->contragent_id = $contragent->id;
        $manager->save();

        event(new ExternalManagerCreated($manager));

        return $manager;
    }
}
