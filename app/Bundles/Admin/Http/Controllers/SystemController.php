<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Admin\Http\Resources\SavedSnapshotResource;
use App\Bundles\Admin\Http\Resources\SnapshotResource;
use App\Bundles\Admin\Models\SystemSnapshot;
use ArtARTs36\SystemInfo\Contracts\System;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class SystemController extends Controller
{
    protected $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * Получить записи о состояниях системы
     */
    public function snapshots(): AnonymousResourceCollection
    {
        return SavedSnapshotResource::collection(SystemSnapshot::all());
    }

    /**
     * Получить актуальное состояние системы
     */
    public function snapshot(): SnapshotResource
    {
        return new SnapshotResource($this->system->createSnapshot());
    }
}
