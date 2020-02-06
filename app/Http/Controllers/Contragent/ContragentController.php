<?php

namespace App\Http\Controllers\Contragent;

use App\ContragentManager;
use App\Http\Requests\ContragentRequest;
use App\Models\Contragent;
use App\Http\Controllers\Controller;
use App\Parsers\DaDataParser\DaDataParser;

class ContragentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
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
     * @return Contragent|\Illuminate\Http\Response
     */
    public function show(Contragent $contragent)
    {
        return $contragent;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContragentRequest $request
     * @param Contragent $contragent
     * @return void
     */
    public function update(ContragentRequest $request, Contragent $contragent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contragent $contragent)
    {
        $contragent->delete();
    }

    public function findInExternalNetworkByInn($inn)
    {
        return DaDataParser::findContragentByInnOrOGRN($inn);
    }

    public function syncWithExternalNetwork(Contragent $contragent)
    {
        // todo
    }
}
