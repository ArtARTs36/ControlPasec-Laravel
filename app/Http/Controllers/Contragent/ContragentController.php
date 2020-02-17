<?php

namespace App\Http\Controllers\Contragent;

use App\ContragentManager;
use App\Http\Requests\ContragentRequest;
use App\Http\Requests\LiveFindContragentRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent;
use App\Http\Controllers\Controller;
use App\Parsers\DaDataParser\DaDataParser;
use App\Services\ContragentService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContragentController extends Controller
{
    /**
     * Получить список контрагентов
     *
     * @return LengthAwarePaginator
     */
    public function index()
    {
        return Contragent::with([
            ContragentManager::PSEUDO,
            Contragent\BankRequisites::PSEUDO
        ])->paginate(10);
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
     */
    public function findInExternalNetworkByInn($inn): ActionResponse
    {
        $contragent = DaDataParser::findContragentByInnOrOGRN($inn);

        return new ActionResponse($contragent instanceof Contragent ? true : false, $contragent);
    }

    public function syncWithExternalNetwork(Contragent $contragent)
    {
        // todo
    }

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
