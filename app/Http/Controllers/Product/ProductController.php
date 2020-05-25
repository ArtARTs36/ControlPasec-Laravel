<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Responses\ActionResponse;
use App\Models\Product\Product;
use App\Models\User\Permission;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    const PERMISSIONS = [
        'index' => Permission::PRODUCTS_LIST_VIEW,
        'show' => Permission::PRODUCTS_VIEW,
        'store' => Permission::PRODUCTS_CREATE,
        'update' => Permission::PRODUCTS_UPDATE,
        'destroy' => Permission::PRODUCTS_DELETE,
    ];

    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(int $page = 1)
    {
        return ProductRepository::paginate($page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Product
     */
    public function store(Request $request): Product
    {
        return Product::create($request->all());
    }

    public function show(Product $product)
    {
        return new ActionResponse(true, $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return ActionResponse
     */
    public function update(Request $request, Product $product): ActionResponse
    {
        $product->setRawAttributes($request->all());

        return new ActionResponse($product->save(), $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return ActionResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        return $this->deleteModelAndResponse($product);
    }

    /**
     * Самые продаваемые продукты
     *
     * @return array
     */
    public function topChart(): array
    {
        return ProductService::getStat(5);
    }

    /**
     * @return array
     */
    public function refreshTopChart(): array
    {
        ProductService::cleanStatCache();

        return $this->topChart();
    }
}
