<?php

namespace App\Bundles\Contract\Http\Controllers;

use App\Bundles\Contract\Http\Requests\StoreTemplate;
use App\Bundles\Contract\Models\ContractTemplate;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use Illuminate\Http\Request;

class ContractTemplateController extends Controller
{
    /**
     * Отобразить все шаблоны договоров
     *
     * @return ContractTemplate[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return ContractTemplate::all();
    }

    /**
     * Создать шаблон договора
     *
     * @param \Illuminate\Http\Request $request
     * @return ContractTemplate
     */
    public function store(StoreTemplate $request): ContractTemplate
    {
        return ContractTemplate::query()->create($request->all());
    }

    /**
     * Отобразить шаблон документа
     *
     * @param ContractTemplate $contractTemplate
     * @return ContractTemplate
     */
    public function show(ContractTemplate $contractTemplate)
    {
        return $contractTemplate;
    }

    /**
     * Обновить шаблон договора
     *
     * @param Request $request
     * @param ContractTemplate $contractTemplate
     * @return ActionResponse
     */
    public function update(Request $request, ContractTemplate $contractTemplate)
    {
        return new ActionResponse($contractTemplate->update($request->all()), $contractTemplate);
    }

    /**
     * Удалить шаблон договора
     *
     * @param ContractTemplate $contractTemplate
     * @return void
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        $contractTemplate->delete();
    }
}
