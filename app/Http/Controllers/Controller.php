<?php

namespace App\Http\Controllers;

use App\Http\Responses\ActionResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="ControlPasec API", version="0.1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const PERMISSIONS = [];

    protected function updateModel(Request $request, Model $model): Model
    {
        $allowInsertFields = $model->getFillable();
        $fields = $request->only($allowInsertFields);

        $model->update($fields);

        return $model;
    }

    /**
     * @param Request $request
     * @param string $modelClass
     * @param bool $save
     * @return Model
     */
    protected function createModel(Request $request, string $modelClass, bool $save = true): Model
    {
        /** @var Model $model */
        $model = new $modelClass();

        $model->fillable($model->getFillable())
            ->fill($request->only($model->getFillable()));

        ($save === true) && $model->save();

        return $model;
    }

    /**
     * @param Request $request
     * @param string $modelClass
     * @return Model
     */
    protected function makeModel(Request $request, string $modelClass): Model
    {
        return $this->createModel($request, $modelClass, false);
    }

    /**
     * @param Request $request
     * @param string $modelClass
     * @return ActionResponse
     */
    protected function createModelAndResponse(Request $request, string $modelClass): ActionResponse
    {
        return new ActionResponse(true, $this->createModel($request, $modelClass));
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return ActionResponse
     */
    protected function updateModelAndResponse(Request $request, Model $model): ActionResponse
    {
        return new ActionResponse(true, $this->updateModel($request, $model));
    }

    /**
     * @param Model $model
     * @return ActionResponse
     * @throws \Exception
     */
    protected function deleteModelAndResponse(Model $model): ActionResponse
    {
        return new ActionResponse($model->delete());
    }
}
