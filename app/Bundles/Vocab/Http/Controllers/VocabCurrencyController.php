<?php

namespace App\Bundles\Vocab\Http\Controllers;

use App\Based\Support\ModelPrioritiesRefresher;
use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\User\Models\Permission;
use App\Bundles\Vocab\Models\VocabCurrency;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

final class VocabCurrencyController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::VOCAB_BANKS_LIST_VIEW,
        'store' => Permission::VOCAB_CURRENCIES_CREATE,
        'show' => Permission::VOCAB_CURRENCIES_VIEW,
        'update' => Permission::VOCAB_CURRENCIES_EDIT,
        'destroy' => Permission::VOCAB_CURRENCIES_DELETE,
    ];

    /**
     * Отобразить список валют
     * @tag VocabCurrency
     * @return LengthAwarePaginator<VocabCurrency>
     */
    public function index($page = 1): LengthAwarePaginator
    {
        return VocabCurrency::paginate(10, ['*'], 'VocabCurrenciesList', $page);
    }

    /**
     * Добавить валюту в справочник
     * @tag VocabCurrency
     */
    public function store(Request $request): ActionResponse
    {
        $currency = new VocabCurrency();
        $currency->fill($request->all());

        return new ActionResponse($currency->save(), $currency);
    }

    /**
     * Отобразить валюту
     * @tag VocabCurrency
     */
    public function show(VocabCurrency $vocabCurrency): VocabCurrency
    {
        return $vocabCurrency;
    }

    /**
     * Обновить данные валюты
     * @tag VocabCurrency
     */
    public function update(Request $request, VocabCurrency $vocabCurrency): ActionResponse
    {
        $refresher = new ModelPrioritiesRefresher($vocabCurrency);
        $refresher->refresh($request->get('priority'));

        $isUpdate = $vocabCurrency->update($request->all());

        return new ActionResponse($isUpdate, $vocabCurrency);
    }

    /**
     * Удалить валюту из справочника
     * @tag VocabCurrency
     * @throws \Exception
     */
    public function destroy(VocabCurrency $vocabCurrency): ActionResponse
    {
        return new ActionResponse($vocabCurrency->delete());
    }
}
