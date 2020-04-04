<?php

namespace App\Http\Controllers\Contragent;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Contragent;
use App\Models\Contragent\ContragentGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ContragentGroupController extends Controller
{
    /**
     * Получить список групп контрагентов
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index($page = 1)
    {
        return Contragent::paginate(10, ['*'], 'ContragentGroupsList', $page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ContragentGroup $contragentGroup
     * @return ContragentGroup
     */
    public function show(ContragentGroup $contragentGroup): ContragentGroup
    {
        return $contragentGroup->load('contragents');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ContragentGroup $contragentGroup
     * @return void
     */
    public function update(Request $request, ContragentGroup $contragentGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ContragentGroup $contragentGroup
     * @return ActionResponse
     */
    public function destroy(ContragentGroup $contragentGroup): ActionResponse
    {
        return new ActionResponse($contragentGroup->delete());
    }
}
