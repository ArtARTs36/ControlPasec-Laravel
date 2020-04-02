<?php

namespace App\Interfaces;

use App\Models\Document\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Interface ModelWithDocuments
 * @property int $id
 * @property Document[]|Collection $documents
 * @property int $supply_id
 */
interface ModelWithDocuments
{
    public function getDocument(): ?Document;

    public function documents(): BelongsToMany;

    public function isExistsDocument(): bool;

    public function isNotExistsDocument(): bool;

    public static function getDocRepo(): DocumentRepository;

    public function save(array $options = []);
}
