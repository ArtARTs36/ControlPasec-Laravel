<?php

namespace App\Http\Controllers\Vocab;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Vocab\VocabCurrency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VocabCurrencyController extends Controller
{
    /**
     * Отобразить список валют
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index($page = 1): LengthAwarePaginator
    {
        return VocabCurrency::paginate(10, ['*'], null, $page);
    }

    /**
     * Добавить валюту в справочник
     *
     * @param Request $request
     * @return ActionResponse
     */
    public function store(Request $request): ActionResponse
    {
        $currency = new VocabCurrency();
        $currency->fill($request->all());

        return new ActionResponse($currency->save(), $currency);
    }

    /**
     * Отобразить валюту
     *
     * @param VocabCurrency $vocabCurrency
     * @return VocabCurrency
     */
    public function show(VocabCurrency $vocabCurrency): VocabCurrency
    {
        return $vocabCurrency;
    }

    /**
     * Обновить данные валюты
     *
     * @param Request $request
     * @param VocabCurrency $vocabCurrency
     * @return ActionResponse
     */
    public function update(Request $request, VocabCurrency $vocabCurrency): ActionResponse
    {
        return new ActionResponse($vocabCurrency->update($request->all()), $vocabCurrency);
    }

    /**
     * Удалить валюту из справочника
     *
     * @param VocabCurrency $vocabCurrency
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(VocabCurrency $vocabCurrency): ActionResponse
    {
        return new ActionResponse($vocabCurrency->delete());
    }
}
