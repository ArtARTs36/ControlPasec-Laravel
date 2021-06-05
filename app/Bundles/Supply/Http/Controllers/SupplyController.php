<?php

namespace App\Bundles\Supply\Http\Controllers;

use App\Bundles\Supply\Contracts\Creator;
use App\Bundles\Supply\Http\Requests\StoreSupply;
use App\Bundles\Supply\Http\Resources\SupplyResource;
use App\Based\Contracts\Controller;
use App\Bundles\Supply\Http\Requests\StoreManySupply;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Supply\Models\Supply;
use App\Bundles\Supply\Models\SupplyStatus;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRepository;
use App\Bundles\Supply\Services\SupplyStatusChanger;
use App\Bundles\User\Models\Permission;
use App\Bundles\Supply\Repositories\SupplyRepository;
use App\Bundles\Supply\Services\SupplyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * @tag Supply
     * @return AnonymousResourceCollection<SupplyResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return SupplyResource::collection($this->repository->paginate());
    }

    /**
     * Создать поставку
     * @tag Supply
     */
    public function store(StoreSupply $request): ActionResponse
    {
        /** @var Supply $supply */
        $supply = $this->makeModel($request, Supply::class);
        $supply->supplier_id = $request->get('supplier_id', $this->service->getDefaultId());
        $supply->save();

        $this->service->checkProductsInSupply($request->toArray(), $supply->id);

        return new ActionResponse(true, $supply);
    }

    /**
     * Открыть поставку
     * @tag Supply
     */
    public function show(Supply $supply): SupplyResource
    {
        return new SupplyResource($this->repository->fullLoad($supply));
    }

    /**
     * Обновить данные о поставке
     * @tag Supply
     */
    public function update(StoreSupply $request, Supply $supply): ActionResponse
    {
        $this->updateModel($request, $supply);

        $this->service->checkProductsInSupply($request->all());

        return new ActionResponse(true, $supply);
    }

    /**
     * @throws \Exception
     * @tag Supply
     */
    public function destroy(Supply $supply)
    {
        return $this->deleteModelAndResponse($supply);
    }

    /**
     * @tag Supply
     */
    public function findByCustomer(int $customerId): ActionResponse
    {
        $supplies = $this->repository->findByCustomer($customerId);

        return new ActionResponse($supplies->isNotEmpty(), $supplies);
    }

    /**
     * @tag Supply
     */
    public function storeMany(StoreManySupply $request, Creator $creator): ActionResponse
    {
        return $creator->many($request->getItems(), $request->getOptions());
    }

    /**
     * Установить статус процедуры
     * @throws \App\Bundles\Supply\Exceptions\SupplyIsAlreadyRequestedStatus
     */
    public function setStatus(Supply $supply, SupplyStatus $status, SupplyStatusChanger $statusChanger): JsonResource
    {
        return new JsonResource($statusChanger->change($supply, $status, $this->getUser()));
    }

    public function history(Supply $supply, SupplyStatusTransitionRepository $transitions): JsonResource
    {
        return JsonResource::collection($transitions->getBySupply($supply));
    }
}
