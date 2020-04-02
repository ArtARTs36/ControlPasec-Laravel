<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Contract\Contract;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContractController extends Controller
{
    /**
     * Отобразить договора
     *
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return Contract::with(['customer', 'supplier'])
            ->paginate(10, ['*'], 'ContractsList', $page);
    }

    /**
     * Создать договор
     *
     * @param ContractRequest $request
     * @return ActionResponse
     */
    public function store(ContractRequest $request): ActionResponse
    {
        $contract = new Contract();
        $contract->fill($request->toArray());
        $contract->supplier_id = env('ONE_SUPPLIER_ID');
        $contract->save();

        return new ActionResponse(true, $contract);
    }

    /**
     * Отобразить договор
     *
     * @param Contract $contract
     * @return Contract
     */
    public function show(Contract $contract): Contract
    {
        return $contract->load([
            'customer',
            'supplier',
            'template',
            'supplies' => function ($query) {
                return $query->with('customer');
            },
        ]);
    }

    /**
     * Обновить договор
     *
     * @param ContractRequest $request
     * @param Contract $contract
     * @return ActionResponse
     */
    public function update(ContractRequest $request, Contract $contract): ActionResponse
    {
        return new ActionResponse($contract->update($request->all()), $contract);
    }

    /**
     * Удалить договор
     *
     * @param Contract $contract
     * @return bool|string
     */
    public function destroy(Contract $contract)
    {
        if ($contract->delete()) {
            return response(null, 204);
        }

        return '';
    }

    /**
     * Поиск договоров по заказчику
     *
     * @param int $customerId
     * @return ActionResponse
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $contracts = Contract::where('customer_id', $customerId)->get();

        return new ActionResponse($contracts->isNotEmpty(), $contracts);
    }
}
