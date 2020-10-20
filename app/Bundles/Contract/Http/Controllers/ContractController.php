<?php

namespace App\Bundles\Contract\Http\Controllers;

use App\Bundles\Contract\Contracts\ContractRepository;
use App\Bundles\Contract\Http\Requests\Store;
use App\Bundles\Contract\Models\Contract;
use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\User\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ContractController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::CONTRACTS_LIST_VIEW,
        'store' => Permission::CONTRACTS_CREATE,
        'show' => Permission::CONTRACTS_VIEW,
        'update' => Permission::CONTRACTS_EDIT,
        'destroy' => Permission::CONTRACTS_DELETE,
    ];

    private $repository;

    public function __construct(ContractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Отобразить договора
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * Создать договор
     */
    public function store(Store $request): ActionResponse
    {
        $contract = $this->makeModel($request, Contract::class);
        $contract->supplier_id = env('ONE_SUPPLIER_ID');
        $contract->save();

        return new ActionResponse(true, $contract);
    }

    /**
     * Отобразить договор
     */
    public function show(Contract $contract): Contract
    {
        return $this->repository->loadFull($contract);
    }

    /**
     * Обновить договор
     */
    public function update(Store $request, Contract $contract): ActionResponse
    {
        return $this->updateModelAndResponse($request, $contract);
    }

    /**
     * Удалить договор
     *
     * @param Contract $contract
     * @return bool|string
     * @throws \Exception
     */
    public function destroy(Contract $contract)
    {
        return $this->deleteModelAndResponse($contract);
    }

    /**
     * Поиск договоров по заказчику
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $contracts = $this->repository->findByCustomer($customerId);

        return new ActionResponse($contracts->isNotEmpty(), $contracts);
    }
}
