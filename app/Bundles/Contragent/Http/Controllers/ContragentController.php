<?php

namespace App\Http\Controllers\Contragent;

use App\Bundles\Contragent\Support\Finder;
use App\Models\Contragent\ContragentManager;
use App\Http\Requests\StoreContragent;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent;
use App\Http\Controllers\Controller;
use App\Models\Sync\SyncWithExternalSystemType;
use App\Models\User\Permission;
use App\Repositories\ContragentRepository;
use App\Services\ContragentService;
use App\Services\SyncWithExternalSystemService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::CONTRAGENTS_LIST_VIEW,
        'store' => Permission::CONTRAGENTS_CREATE,
        'show' => Permission::CONTRAGENTS_VIEW,
        'update' => Permission::CONTRAGENTS_EDIT,
        'destroy' => Permission::CONTRAGENTS_DELETE,
        'findInExternalNetworkByInn' => Permission::CONTRAGENTS_FIND_EXTERNAL_SYSTEM,
    ];

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
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return Contragent::with([
            Contragent::RELATION_MANAGERS,
            Contragent::RELATION_REQUISITES,
        ])->paginate(10, ['*'], 'ContragentsList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContragent $request
     * @return ActionResponse
     */
    public function store(StoreContragent $request): ActionResponse
    {
        return $this->createModelAndResponse($request, Contragent::class);
    }

    /**
     * Display the specified resource.
     *
     * @param Contragent $contragent
     * @return ActionResponse
     */
    public function show(Contragent $contragent): ActionResponse
    {
        return new ActionResponse(true, ContragentService::getFullInfo($contragent));
    }

    /**
     * Обновить данные о контрагенте
     *
     * @param StoreContragent $request
     * @param Contragent $contragent
     * @return ActionResponse
     */
    public function update(StoreContragent $request, Contragent $contragent)
    {
        $this->updateModel($request, $contragent);

        ContragentService::updateScoresInRequisiteByRequest($request);

        return new ActionResponse(true, $contragent);
    }

    /**
     * Удалить контрагента
     *
     * @param Contragent $contragent
     * @return ActionResponse
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
    public function destroy(Contragent $contragent)
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
    public function findInExternalNetworkByInn($inn, Finder $finder): ActionResponse
    {
        if ($contragent = ContragentRepository::findByInnOrOgrn($inn)) {
            return new ActionResponse(true, [
                'message' => 'Контрагент '. $contragent->title . ' уже существует в базе',
                'contragent' => $contragent,
            ]);
        }

        $contragent = $finder->findByInnOrOgrn($inn);

        return new ActionResponse(true, [
            'message' => 'Контрагент '. $contragent->first()->title . ' найден!',
            'contragent' => $contragent,
        ]);
    }

    /**
     * Синхронизировать контрагента с данными из внешней системы
     * @param Contragent $contragent
     * @return array
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
    public function liveFind(string $term)
    {
        $contragents = Contragent::query()
            ->where('title', 'LIKE', "%{$term}%")
            ->orWhere('full_title', 'LIKE', "%{$term}%")
            ->orWhere('full_title_with_opf', 'LIKE', "%{$term}%")
            ->orWhere('inn', 'LIKE', "%{$term}%")
            ->orWhere('kpp', 'LIKE', "%{$term}%")
            ->get()
            ->all();

        return new ActionResponse(count($contragents) > 0, $contragents);
    }
}
