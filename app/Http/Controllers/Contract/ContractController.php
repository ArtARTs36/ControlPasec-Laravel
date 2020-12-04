<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Responses\ActionResponse;
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
     *
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->repository->paginate($page);
    }

    /**
     * Создать договор
     *
     * @param ContractRequest $request
     * @return ActionResponse
     */
    public function store(ContractRequest $request): ActionResponse
    {
        $contract = $this->makeModel($request, Contract::class);
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
        return $this->repository->loadFull($contract);
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
     *
     * @param int $customerId
     * @return ActionResponse
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $contracts = $this->repository->findByCustomer($customerId);

        return new ActionResponse($contracts->isNotEmpty(), $contracts);
    }
}
