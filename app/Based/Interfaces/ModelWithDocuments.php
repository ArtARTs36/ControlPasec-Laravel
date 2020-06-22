<?php

namespace App\Based\Interfaces;

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
    /**
     * @return Document|null
     */
    public function getDocument(): ?Document;

    /**
     * @return BelongsToMany
     */
    public function documents(): BelongsToMany;

    /**
     * @return bool
     */
    public function isExistsDocument(): bool;

    /**
     * @return bool
     */
    public function isNotExistsDocument(): bool;

    /**
     * @return DocumentRepository
     */
    public static function getDocRepo(): DocumentRepository;

    /**
     * @param array $options
     * @return mixed
     */
    public function save(array $options = []);
}
