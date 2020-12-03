<?php

namespace App\Http\Controllers\Supply;

use App\Bundles\Supply\Http\Resources\SupplyResource;
use App\Helper\SupplierHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Supply\SupplyStoreManyRequest;
use App\Http\Requests\SupplyRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Supply\Supply;
use App\Bundles\User\Models\Permission;
use App\Repositories\SupplyRepository;
use App\Services\Supply\SupplyCreator;
use App\Services\SupplyService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupplyController extends Controller
{
    public const PERMISSIONS = [
        'index' => Permission::SUPPLIES_VIEW,
        'show' => Permission::SUPPLIES_VIEW,
        'store' => Permission::SUPPLIES_CREATE,
        'update' => Permission::SUPPLIES_EDIT,
        'destroy' => Permission::SUPPLIES_DELETE,
    ];

    /**
     * Получить список поставок
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return SupplyResource::collection(SupplyRepository::paginate());
    }

    /**
     * Создать поставку
     *
     * @param SupplyRequest $request
     * @return ActionResponse
     */
    public function store(SupplyRequest $request): ActionResponse
    {
        $supply = $this->makeModel($request, Supply::class);
        $supply->supplier_id = $request->get('supplier_id', SupplierHelper::getDefaultId());
        $supply->save();

        SupplyService::checkProductsInSupply($request, $supply->id);

        return new ActionResponse(true, $supply);
    }

    /**
     * Открыть поставку
     *
     * @param Supply $supply
     * @return SupplyResource
     */
    public function show(Supply $supply): SupplyResource
    {
        return new SupplyResource(SupplyRepository::fullLoad($supply));
    }

    /**
     * Обновить данные о поставке
     *
     * @param SupplyRequest $request
     * @param Supply $supply
     * @return ActionResponse
     */
    public function update(SupplyRequest $request, Supply $supply): ActionResponse
    {
        $this->updateModel($request, $supply);

        SupplyService::checkProductsInSupply($request->all());

        return new ActionResponse(true, $supply);
    }

    /**
     * @param Supply $supply
     * @return ActionResponse
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
        $supplies = SupplyRepository::findByCustomer($customerId);

        return new ActionResponse($supplies->isNotEmpty(), $supplies);
    }

    /**
     * @param SupplyStoreManyRequest $request
     * @return ActionResponse
     */
    public function storeMany(SupplyStoreManyRequest $request): ActionResponse
    {
        return SupplyCreator::many($request->getItems(), $request->getOptions());
    }
}
