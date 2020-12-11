<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Bundles\Contragent\Support\Finder;
use App\Bundles\Contragent\Http\Requests\StoreContragent;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Contragent\Models\Contragent;
use App\Based\Contracts\Controller;
use App\Based\Models\SyncWithExternalSystemType;
use App\Bundles\User\Models\Permission;
use App\Bundles\Contragent\Repositories\ContragentRepository;
use App\Bundles\Contragent\Services\ContragentService;
use App\Services\SyncWithExternalSystemService;
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
     * Отобразить список контрагентов
     *
     * @OA\Get(
     *     path="/api/contragents/page-{page}",
     *     description="Contragents: index Page",
     *     tags={"Contragent Actions"},
     *     @OA\Parameter(
     *      name="page",
     *      in="path",
     *      required=true,
     *      @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response="default", description="View Contragents")
     * )
     *
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    public function store(StoreContragent $request): ActionResponse
    {
        return $this->createModelAndResponse($request, Contragent::class);
    }

    public function show(Contragent $contragent): ActionResponse
    {
        return new ActionResponse(true, $this->service->loadFullInfo($contragent));
    }

    /**
     * Обновить данные о контрагенте
     */
    public function update(StoreContragent $request, Contragent $contragent)
    {
        $this->updateModel($request, $contragent);

        $this->service->updateScoresInRequisiteByRequest($request);

        return new ActionResponse(true, $contragent);
    }

    /**
     * Удалить контрагента
     *
     * @OA\Delete(
     *     path="/api/contragents/{id}",
     *     description="Contragents: delete item",
     *     tags={"Contragent Actions"},
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true
     *     ),
     *     @OA\Response(response="default", description="Contragents: delete item")
     * )
     */
    public function destroy(Contragent $contragent): ActionResponse
    {
        $contragent->delete();

        return new ActionResponse(true);
    }

    /**
     * Поиск контрагента во внешней системе
     *
     * @param int $inn
     * @return ActionResponse
     *
     * @OA\Get(
     *     path="/api/contragents/find-external-by-inn/{inn}",
     *     description="Contragents: find Contragent in external System",
     *     tags={"Contragent Actions"},
     *     @OA\Parameter(
     *      name="inn",
     *      in="path",
     *      required=true
     *     ),
     *     @OA\Response(response="default", description="Contragents: find Contragent in external System")
     * )
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
     */
    public function syncWithExternalSystem(Contragent $contragent, Finder $finder): array
    {
        $response = $finder->findByInnOrOgrn($contragent->inn ?? $contragent->ogrn, false);

        return (new SyncWithExternalSystemService($contragent, SyncWithExternalSystemType::SLUG_CONTRAGENT_DADATA))
            ->create($response)
            ->getComparedData();
    }

    /**
     * Живой поиск контрагента в базе
     *
     * @param string $term
     * @return ActionResponse
     *
     * @OA\Get(
     *     path="/api/contragents/live-find/{term}",
     *     description="Contragents: live find in Base",
     *     tags={"Contragent Actions"},
     *     @OA\Parameter(
     *      name="inn",
     *      in="path",
     *      required=true
     *     ),
     *     @OA\Response(response="default", description="Contragents: live find in Base")
     * )
     */
    public function liveFind(string $term): ActionResponse
    {
        $contragents = $this->service->relevantSearch($term);

        return new ActionResponse($contragents->count() > 0, $contragents->all());
    }
}
