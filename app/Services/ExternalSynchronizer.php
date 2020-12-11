<?php

namespace App\Services;

use App\Based\Models\ModelType;
use App\Based\Models\ExternalSystemExchange;
use App\Based\Models\ExternalSystem;
use Illuminate\Database\Eloquent\Model;

class ExternalSynchronizer
{
    /** @var Model */
    private $model;

    /** @var ModelType */
    private $modelType = null;

    /** @var string */
    private $typeSlug;

    /** @var ExternalSystem */
    private $type = null;

    /** @var string|null */
    private $response = null;

    public function __construct(Model $model, string $slug, ?string $response = null)
    {
        $this->model = $model;
        $this->typeSlug = $slug;
        $this->response = $response;
    }

    /**
     * @return ExternalSystem
     */
    private function getType(): ExternalSystem
    {
        if ($this->type === null) {
            $this->type = ExternalSystem::where('slug', $this->typeSlug)->first();
        }

        return $this->type;
    }

    /**
     * @return ModelType
     */
    private function getModelType(): ModelType
    {
        if ($this->modelType === null) {
            $this->modelType = ModelType::where('class', get_class($this->model))->first();
        }

        return $this->modelType;
    }

    /**
     * @param string|null $response
     * @return ExternalSystemExchange
     */
    public function create(?string $response = null): ExternalSystemExchange
    {
        $sync = new ExternalSystemExchange();
        $sync->fill([
            'type_id' => $this->getType()->id,
            'model_type_id' => $this->getModelType()->id,
            'model_id' => $this->model->id,
            'response' => $response = $response ?? $this->response
        ]);
        $sync->save();

        $sync->modelType = $this->getModelType();
        $sync->type = $this->getType();

        return $sync;
    }
}
