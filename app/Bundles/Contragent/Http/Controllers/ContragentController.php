<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Bundles\Contragent\Http\Resources\ShowContragent;
use App\Bundles\Contragent\Services\Synchronizer;
use App\Bundles\Contragent\Support\Finder;
use App\Bundles\Contragent\Http\Requests\StoreContragent;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Contragent\Models\Contragent;
use App\Based\Contracts\Controller;
use App\Bundles\User\Models\Permission;
use App\Bundles\Contragent\Repositories\ContragentRepository;
use App\Bundles\Contragent\Services\ContragentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ContragentController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::CONTRAGENTS_LIST_VIEW,
        'store' => Permission::CONTRAGENTS_CREATE,
        'show' => Permission::CONTRAGENTS_VIEW,
        'update' => Permission::CONTRAGENTS_EDIT,
        'destroy' => Permission::CONTRAGENTS_DELETE,
        'findInExternalNetworkByInn' => Permission::CONTRAGENTS_FIND_EXTERNAL_SYSTEM,
    ];

    private $repository;

    private $service;

    public function __construct(ContragentRepository $repository, ContragentService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @tag Contragent
     * @return LengthAwarePaginator<Contragent>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * @tag Contragent
     */
    public function store(StoreContragent $request): ShowContragent
    {
        $contragent = $this->createModel($request, Contragent::class);

        return new ShowContragent($contragent);
    }

    /**
     * @tag Contragent
     */
    public function show(Contragent $contragent): ActionResponse
    {
        return new ActionResponse(true, $this->service->loadFullInfo($contragent));
    }

    /**
     * Обновить данные о контрагенте
     * @tag Contragent
     */
    public function update(StoreContragent $request, Contragent $contragent): ShowContragent
    {
        $this->updateModel($request, $contragent);

        $this->service->updateScoresInRequisiteByRequest($request);

        return new ShowContragent($contragent);
    }

    /**
     * Удалить контрагента
     * @tag Contragent
     */
    public function destroy(Contragent $contragent): ActionResponse
    {
        $contragent->delete();

        return new ActionResponse(true);
    }

    /**
     * Поиск контрагента во внешней системе
     * @tag Contragent
     */
    public function findInExternalNetworkByInn($inn, Finder $finder, ContragentRepository $repository): ActionResponse
    {
        if ($contragent = $repository->findByInnOrOgrn($inn)) {
            return new ActionResponse(true, [
                'message' => 'Контрагент '. $contragent->title . ' уже существует в базе',
                'contragent' => $contragent,
            ]);
        }

        $contragent = $finder->findByInnOrOgrn($inn)->first();

        if (! $contragent) {
            abort(404);
        }

        return new ActionResponse(true, [
            'message' => 'Контрагент '. $contragent->title . ' найден!',
            'contragent' => $contragent,
        ]);
    }

    /**
     * Синхронизировать контрагента с данными из внешней системы
     * @tag Contragent
     */
    public function syncWithExternalSystem(Contragent $contragent, Synchronizer $synchronizer): array
    {
        return $synchronizer->exchange($contragent)->getComparedData();
    }

    /**
     * Живой поиск контрагента в базе
     * @tag Contragent
     */
    public function liveFind(string $term): ActionResponse
    {
        $contragents = $this->service->relevantSearch($term);

        return new ActionResponse($contragents->count() > 0, $contragents->all());
    }
}
