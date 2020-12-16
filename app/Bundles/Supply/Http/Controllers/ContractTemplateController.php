<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Supply\Models\ContractTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContractTemplateController extends Controller
{
    /**
     * Отобразить все шаблоны договоров
     * @tag ContractTemplate
     */
    public function index(): Collection
    {
        return ContractTemplate::all();
    }

    /**
     * Создать шаблон договора
     * @tag ContractTemplate
     */
    public function store(Request $request): ContractTemplate
    {
        return ContractTemplate::create($request->all());
    }

    /**
     * Отобразить шаблон документа
     * @tag ContractTemplate
     */
    public function show(ContractTemplate $contractTemplate)
    {
        return $contractTemplate;
    }

    /**
     * Обновить шаблон договора
     * @tag ContractTemplate
     */
    public function update(Request $request, ContractTemplate $contractTemplate)
    {
        return new ActionResponse($contractTemplate->update($request->all()), $contractTemplate);
    }

    /**
     * Удалить шаблон договора
     * @tag ContractTemplate
     */
    public function destroy(ContractTemplate $contractTemplate)
    {
        $contractTemplate->delete();
    }
}
