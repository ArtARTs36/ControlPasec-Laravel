<?php

namespace App\Bundles\Product\Http\Controllers;

use App\Bundles\Product\Repositories\ProductRepository;
use App\Bundles\Product\Services\ProductService;
use App\Based\Contracts\Controller;
use App\Bundles\Product\Http\Requests\StoreProduct;
use App\Based\Http\Responses\ActionResponse;
use App\Bundles\Product\Models\Product;
use App\Bundles\User\Models\Permission;

final class ProductController extends Controller
{
    const PERMISSIONS = [
        'index' => Permission::PRODUCTS_LIST_VIEW,
        'show' => Permission::PRODUCTS_VIEW,
        'store' => Permission::PRODUCTS_CREATE,
        'update' => Permission::PRODUCTS_UPDATE,
        'destroy' => Permission::PRODUCTS_DELETE,
    ];

    private $repository;

    private $service;

    public function __construct(ProductRepository $repository, ProductService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index(int $page = 1)
    {
        return $this->repository->paginate($page);
    }

    public function store(StoreProduct $request): Product
    {
        return $this->createModel($request, Product::class);
    }

    public function show(Product $product): ActionResponse
    {
        return new ActionResponse(true, $product);
    }

    public function update(StoreProduct $request, Product $product): ActionResponse
    {
        return $this->updateModelAndResponse($request, $product);
    }

    public function destroy(Product $product): ActionResponse
    {
        return $this->deleteModelAndResponse($product);
    }

    public function topChart(): array
    {
        return $this->service->getStat(5);
    }

    public function refreshTopChart(): array
    {
        $this->service->cleanStatCache();

        return $this->topChart();
    }
}
