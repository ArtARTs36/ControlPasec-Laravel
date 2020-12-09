<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Bundles\Supply\Contracts\Creator;
use App\Bundles\Supply\Http\Requests\StoreSupply;
use App\Bundles\Supply\Http\Resources\SupplyResource;
use App\Helper\SupplierHelper;
use App\Http\Controllers\Controller;
use App\Bundles\Supply\Http\Requests\StoreManySupply;
use App\Http\Responses\ActionResponse;
use App\Models\Supply\Supply;
use App\Bundles\User\Models\Permission;
use App\Bundles\Supply\Repositories\SupplyRepository;
use App\Bundles\Supply\Services\SupplyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SupplyController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::SUPPLIES_VIEW,
        'show' => Permission::SUPPLIES_VIEW,
        'store' => Permission::SUPPLIES_CREATE,
        'update' => Permission::SUPPLIES_EDIT,
        'destroy' => Permission::SUPPLIES_DELETE,
    ];

    private $repository;

    private $service;

    public function __construct(SupplyRepository $repository, SupplyService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Получить список поставок
     */
    public function index(): AnonymousResourceCollection
    {
        return SupplyResource::collection($this->repository->paginate());
    }

    /**
     * Создать поставку
     */
    public function store(StoreSupply $request): ActionResponse
    {
        $supply = $this->makeModel($request, Supply::class);
        $supply->supplier_id = $request->get('supplier_id', SupplierHelper::getDefaultId());
        $supply->save();

        $this->service->checkProductsInSupply($request->toArray(), $supply->id);

        return new ActionResponse(true, $supply);
    }

    /**
     * Открыть поставку
     */
    public function show(Supply $supply): SupplyResource
    {
        return new SupplyResource($this->repository->fullLoad($supply));
    }

    /**
     * Обновить данные о поставке
     */
    public function update(StoreSupply $request, Supply $supply): ActionResponse
    {
        $this->updateModel($request, $supply);

        $this->service->checkProductsInSupply($request->all());

        return new ActionResponse(true, $supply);
    }

    /**
     * @throws \Exception
     */
    public function destroy(Supply $supply)
    {
        return $this->deleteModelAndResponse($supply);
    }

    /**
     * @param int $customerId
     * @return ActionResponse
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $supplies = $this->repository->findByCustomer($customerId);

        return new ActionResponse($supplies->isNotEmpty(), $supplies);
    }

    public function storeMany(StoreManySupply $request, Creator $creator): ActionResponse
    {
        return $creator->many($request->getItems(), $request->getOptions());
    }
}
