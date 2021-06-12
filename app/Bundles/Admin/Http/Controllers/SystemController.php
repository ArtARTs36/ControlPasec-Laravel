<?php

namespace App\Bundles\Admin\Http\Controllers;

use App\Based\Contracts\Controller;
use App\Bundles\Admin\Http\Resources\SavedSnapshotResource;
use App\Bundles\Admin\Http\Resources\SnapshotResource;
use App\Bundles\Admin\Models\SystemSnapshot;
use App\Bundles\Admin\Repositories\SystemSnapshotRepository;
use ArtARTs36\SystemInfo\Contracts\System;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;

class SystemController extends Controller
{
    protected $system;

    protected $snapshots;

    public function __construct(System $system, SystemSnapshotRepository $snapshots)
    {
        $this->system = $system;
        $this->snapshots = $snapshots;
    }

    /**
     * Получить записи о состояниях системы
     */
    public function snapshots(): AnonymousResourceCollection
    {
        return SavedSnapshotResource::collection($this->snapshots->all());
    }

    /**
     * Получить актуальное состояние системы
     */
    public function snapshot(): SnapshotResource
    {
        return new SnapshotResource($this->system->createSnapshot());
    }
}
