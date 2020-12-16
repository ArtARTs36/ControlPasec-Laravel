<?php

namespace App\Bundles\Contragent\Services;

use App\Bundles\Contragent\Models\BankRequisites;
use App\Bundles\Contragent\Repositories\ContragentRepository;
use App\Bundles\Contragent\Http\Requests\StoreContragent;
use App\Bundles\Contragent\Models\Contragent;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class ContragentService
{
    private $repository;

    public function __construct(ContragentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function relevantSearch(string $term): Collection
    {
        return $this->repository->findLikeByFields([
            Contragent::FIELD_TITLE, Contragent::FIELD_FULL_TITLE_WITH_OPF,
            Contragent::FIELD_INN, Contragent::FIELD_KPP,
        ], $term);
    }

    /**
     * Получить полную информацию по контрагенту
     * @param Contragent $contragent
     * @return Contragent
     */
    public function loadFullInfo(Contragent $contragent): Contragent
    {
        return $contragent->load([
            Contragent::RELATION_MANAGERS,
            Contragent::RELATION_REQUISITES => function ($query) {
                return $query->with(BankRequisites::RELATION_BANK);
            },
        ]);
    }

    /**
     * Обновить счета в реквизитах
     *
     * @param StoreContragent $request
     * @return BankRequisites[]|null
     */
    public function updateScoresInRequisiteByRequest(StoreContragent $request): ?Collection
    {
        $data = $request->all();
        if (! isset($data['requisites']) && ! is_array($data['requisites'])) {
            return null;
        }

        $requisites = BankRequisites::query()->findMany(
            Arr::pluck($data['requisites'], 'id')
        );

        foreach ($requisites as $req) {
            $req->update([
                BankRequisites::FIELD_SCORE => $req['score']
            ]);
        }

        return $requisites;
    }
}
