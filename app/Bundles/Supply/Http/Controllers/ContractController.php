<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Supply\Http\Requests\StoreContract;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Supply\Models\Contract;
use App\Bundles\User\Models\Permission;
use App\Bundles\Supply\Repositories\ContractRepository;
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
     * @tag Contract
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * Создать договор
     * @tag Contract
     */
    public function store(StoreContract $request): ActionResponse
    {
        $contract = $this->makeModel($request, Contract::class);
        $contract->supplier_id = $contract->supplier_id ?? env('ONE_SUPPLIER_ID');
        $contract->save();

        return new ActionResponse(true, $contract);
    }

    /**
     * Отобразить договор
     * @tag Contract
     */
    public function show(Contract $contract): Contract
    {
        return $this->repository->loadFull($contract);
    }

    /**
     * Обновить договор
     * @tag Contract
     */
    public function update(StoreContract $request, Contract $contract): ActionResponse
    {
        return $this->updateModelAndResponse($request, $contract);
    }

    /**
     * Удалить договор
     * @tag Contract
     */
    public function destroy(Contract $contract)
    {
        return $this->deleteModelAndResponse($contract);
    }

    /**
     * Поиск договоров по заказчику
     * @tag Contract
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $contracts = $this->repository->findByCustomer($customerId);

        return new ActionResponse($contracts->isNotEmpty(), $contracts);
    }
}
