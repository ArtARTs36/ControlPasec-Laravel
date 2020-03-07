<?php

namespace App\Models\Sync;

use App\Models\ModelType;
use App\Models\Traits\WithModelType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SyncWithExternalSystem
 * @property int id
 * @property int type_id
 * @property SyncWithExternalSystemType type
 * @property int model_type_id
 * @property ModelType model_type
 * @property int model_id
 * @property Model model
 * @property string response
 */
class SyncWithExternalSystem extends Model
{
    use WithModelType;

    public function model(): Model
    {
        $class = $this->model_type->class;

        return $class::find($this->model_id);
    }
}
