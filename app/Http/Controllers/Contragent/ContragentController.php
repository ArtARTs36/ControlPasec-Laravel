<?php

namespace App\Http\Controllers\Contragent;

use App\Models\Contragent\ContragentManager;
use App\Http\Requests\ContragentRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent;
use App\Http\Controllers\Controller;
use App\Models\Sync\SyncWithExternalSystemType;
use App\Parsers\DaDataParser\DaDataParser;
use App\Services\ContragentService;
use App\Services\SyncWithExternalSystemService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentController extends Controller
{
    /**
     * Отобразить список контрагентов
     *
     * @OA\Get(
     *     path="/contragents/page-{page}",
     *     description="Contragents: index Page",
     *     @OA\Parameter(
     *      name="page",
     *      in="path",
     *      required=false,
     *      @OA\Schema(type="int")
     *     ),
     *     @OA\Response(response="default", description="View Contragents")
     * )
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index($page = 1)
    {
        return Contragent::with([
            ContragentManager::PSEUDO,
            Contragent\BankRequisites::PSEUDO
        ])->paginate(10, ['*'], null, $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContragentRequest $request
     * @return void
     */
    public function store(ContragentRequest $request)
    {
        $contragent = new Contragent();

        $contragent->fillable($contragent->getFillable())
        ->fill($request->only($contragent->getFillable()));
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
     * @param ContragentRequest $request
     * @param Contragent $contragent
     * @return ActionResponse
     */
    public function update(ContragentRequest $request, Contragent $contragent)
    {
        $data = $request->all();

        $contragent->update($data);

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
     *     path="/contragents/{id}",
     *     description="Contragents: delete item",
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
     * @param $inn
     * @return ActionResponse
     *
     * @OA\Get(
     *     path="/contragents/find-external-by-inn/{inn}",
     *     description="Contragents: find Contragent in external System",
     *     @OA\Parameter(
     *      name="inn",
     *      in="path",
     *      required=true
     *     ),
     *     @OA\Response(response="default", description="Contragents: find Contragent in external System")
     * )
     */
    public function findInExternalNetworkByInn($inn): ActionResponse
    {
        $contragent = DaDataParser::findContragentByInnOrOGRN($inn);

        return new ActionResponse($contragent instanceof Contragent ? true : false, $contragent);
    }

    /**
     * Синхронизировать контрагента с данными из внешней системы
     * @param Contragent $contragent
     * @return array
     */
    public function syncWithExternalSystem(Contragent $contragent): array
    {
        $response = DaDataParser::findContragentByInnOrOGRN(
            $contragent->inn ?? $contragent->ogrn,
            true,
            false
        );

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
     *     path="/contragents/live-find/{term}",
     *     description="Contragents: live find in Base",
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
        $contragents = Contragent::where('title', 'LIKE', "%{$term}%")
            ->orWhere('full_title', 'LIKE', "%{$term}%")
            ->orWhere('full_title_with_opf', 'LIKE', "%{$term}%")
            ->orWhere('inn', 'LIKE', "%{$term}%")
            ->orWhere('kpp', 'LIKE', "%{$term}%")
            ->get()
            ->all();

        return new ActionResponse(count($contragents) > 0, $contragents);
    }
}
