<?php

namespace App\Bundles\Contragent\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Contragent\Http\Requests\StoreMyContragent;
use App\Bundles\Contragent\Models\MyContragent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class MyContragentController extends Controller
{
    /**
     * @tag MyContragent
     */
    public function index(): LengthAwarePaginator
    {
        return MyContragent::paginate(10);
    }

    /**
     * @tag MyContragent
     */
    public function store(StoreMyContragent $request): JsonResource
    {
        return new JsonResource((new MyContragent())->fillOfRequest($request));
    }

    /**
     * @tag MyContragent
     */
    public function show(MyContragent $myContragent)
    {
        return $myContragent;
    }

    /**
     * @tag MyContragent
     */
    public function update(StoreMyContragent $request, MyContragent $myContragent): JsonResource
    {
        return new JsonResource($myContragent->fillOfRequest($request));
    }

    /**
     * @tag MyContragent
     */
    public function destroy(MyContragent $myContragent)
    {
        $myContragent->delete();
    }
}
