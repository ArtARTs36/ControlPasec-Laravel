<?php

namespace App\Bundles\Contragent\Support;

use App\Bundles\Contragent\Contracts\ContragentFinder;
use App\Bundles\Contragent\Events\ExternalManagerCreated;
use App\Bundles\Contragent\Models\Contragent;
use App\Bundles\Contragent\Models\ContragentManager;
use ArtARTs36\RuSpelling\People;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Support\Collection;

class Finder implements ContragentFinder
{
    protected $managers;

    protected $client;

    protected $events;

    public function __construct(DaDataClient $client, EventDispatcher $events)
    {
        $this->managers = collect();
        $this->client = $client;
        $this->events = $events;
    }

    /**
     * @return Collection|Contragent[]
     */
    public function findAndCreateByInnOrOgrn(string $slug): Collection
    {
        return $this->findByInnOrOgrn($slug)
            ->each(function (Contragent $contragent) {
                $contragent->save();
                $contragent->managers->each(function (ContragentManager $manager) use ($contragent) {
                    $manager->contragent_id = $contragent->id;
                    $manager->save();
                });
            });
    }

    /**
     * @return Collection|Contragent[]
     */
    public function findByInnOrOgrn(string $slug): Collection
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

            $contragents->push($contragent);

            if (isset($response['management']['name'])) {
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
        $people = People::fromFio($response['management']['name']);

        if ($people === null) {
            return null;
        }

        $manager = new ContragentManager();

        $manager->name = $people->name;
        $manager->patronymic = $people->patronymic;
        $manager->family = $people->family;

        if (! empty($response['management']['post'])) {
            $manager->post = $response['management']['post'];
        }

        $contragent->managers->push($manager);

        event(new ExternalManagerCreated($manager));

        return $manager;
    }
}
