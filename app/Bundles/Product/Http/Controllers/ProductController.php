<?php

namespace App\Bundles\Product\Http\Controllers;

use App\Bundles\Product\Services\ProductService;
use App\Based\Contracts\Controller;
use App\Bundles\Product\Http\Requests\StoreProduct;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Product\Models\Product;
use App\Bundles\User\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ProductController extends Controller
{
    const PERMISSIONS = [
        'index' => Permission::PRODUCTS_LIST_VIEW,
        'show' => Permission::PRODUCTS_VIEW,
        'store' => Permission::PRODUCTS_CREATE,
        'update' => Permission::PRODUCTS_UPDATE,
        'destroy' => Permission::PRODUCTS_DELETE,
        'topChart' => Permission::PRODUCTS_LIST_VIEW,
        'refreshTopChart' => Permission::PRODUCTS_LIST_VIEW,
    ];

    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @tag Product
     * @return LengthAwarePaginator<Product>
     */
    public function index(int $page = 1): LengthAwarePaginator
    {
        return $this->service->show($page);
    }

    /**
     * @tag Product
     */
    public function store(StoreProduct $request): Product
    {
        return $this->createModel($request, Product::class);
    }

    /**
     * @tag Product
     */
    public function show(Product $product): ActionResponse
    {
        return new ActionResponse(true, $product);
    }

    /**
     * @tag Product
     */
    public function update(StoreProduct $request, Product $product): ActionResponse
    {
        return $this->updateModelAndResponse($request, $product);
    }

    /**
     * @tag Product
     */
    public function destroy(Product $product): ActionResponse
    {
        return $this->deleteModelAndResponse($product);
    }

    /**
     * @tag Product
     */
    public function topChart(): array
    {
        return $this->service->getStat(5);
    }

    /**
     * @tag Product
     */
    public function refreshTopChart(): array
    {
        $this->service->cleanStatCache();

        return $this->topChart();
    }
}
