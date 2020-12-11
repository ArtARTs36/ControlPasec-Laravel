<?php

namespace App\Services;

use App\Based\Models\ModelType;
use App\Based\Models\SyncWithExternalSystem;
use App\Based\Models\SyncWithExternalSystemType;
use Illuminate\Database\Eloquent\Model;

class SyncWithExternalSystemService
{
    /** @var Model */
    private $model;

    /** @var ModelType */
    private $modelType = null;

    /** @var string */
    private $typeSlug;

    /** @var SyncWithExternalSystemType */
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
     * @return SyncWithExternalSystemType
     */
    private function getType(): SyncWithExternalSystemType
    {
        if ($this->type === null) {
            $this->type = SyncWithExternalSystemType::where('slug', $this->typeSlug)->first();
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
     * @return SyncWithExternalSystem
     */
    public function create(?string $response = null): SyncWithExternalSystem
    {
        $sync = new SyncWithExternalSystem();
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
