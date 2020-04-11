<?php

namespace App\Http\Controllers;

use App\Http\Responses\ActionResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(title="ControlPasec API", version="0.1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function updateModel(FormRequest $request, Model $model): Model
    {
        $allowInsertFields = $model->getFillable();
        $fields = $request->only($allowInsertFields);

        $model->update($fields);

        return $model;
    }

    /**
     * @param FormRequest $request
     * @param string $modelClass
     * @param bool $save
     * @return Model
     */
    protected function createModel(FormRequest $request, string $modelClass, bool $save = true): Model
    {
        /** @var Model $model */
        $model = new $modelClass();

        $model->fillable($model->getFillable())
            ->fill($request->only($model->getFillable()));

        ($save === true) && $model->save();

        return $model;
    }

    protected function createModelAndResponse(FormRequest $request, string $modelClass): ActionResponse
    {
        return new ActionResponse(true, $this->createModel($request, $modelClass));
    }

    protected function updateModelAndResponse(FormRequest $request, Model $model): ActionResponse
    {
        return new ActionResponse(true, $this->updateModel($request, $model));
    }
}
