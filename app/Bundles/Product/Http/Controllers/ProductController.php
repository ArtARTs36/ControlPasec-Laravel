<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Responses\ActionResponse;
use App\Models\Product\Product;
use App\Models\User\Permission;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    const PERMISSIONS = [
        'index' => Permission::PRODUCTS_LIST_VIEW,
        'show' => Permission::PRODUCTS_VIEW,
        'store' => Permission::PRODUCTS_CREATE,
        'update' => Permission::PRODUCTS_UPDATE,
        'destroy' => Permission::PRODUCTS_DELETE,
    ];

    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(int $page = 1): LengthAwarePaginator
    {
        return ProductRepository::paginate($page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @return Product
     */
    public function store(ProductUpdateRequest $request): Product
    {
        return $this->createModel($request, Product::class);
    }

    /**
     * @param Product $product
     * @return ActionResponse
     */
    public function show(Product $product): ActionResponse
    {
        return new ActionResponse(true, $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return ActionResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): ActionResponse
    {
        return $this->updateModelAndResponse($request, $product);
    }

    /**
     * Удалить продукт
     * @throws \Exception
     */
    public function destroy(Product $product): ActionResponse
    {
        return $this->deleteModelAndResponse($product);
    }

    /**
     * Получить самые продаваемые продукты
     */
    public function topChart(): array
    {
        return $this->service->getStat(5);
    }

    /**
     * @return array
     */
    public function refreshTopChart(): array
    {
        $this->service->cleanStatCache();

        return $this->topChart();
    }
}
