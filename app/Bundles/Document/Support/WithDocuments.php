<?php

namespace App\Bundles\Document\Support;

use App\Models\Document\Document;
use App\Bundles\Document\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property Collection|Document[] $documents
 */
trait WithDocuments
{
    private static $docRepo = null;

    /**
     * @codeCoverageIgnore
     */
    public function documents(): BelongsToMany
    {
        return $this->morphToMany(
            Document::class,
            'entity',
            'document_entity',
            'document_id',
            'entity_id',
            null,
            null,
            false
        );
    }

    /**
     * Получить первый документ
     * @return Document|null
     */
    public function getDocument(): ?Document
    {
        return $this->documents->first();
    }

    /**
     * @return bool
     */
    public function isExistsDocument(): bool
    {
        return ! $this->isNotExistsDocument();
    }

    /**
     * @return bool
     */
    public function isNotExistsDocument(): bool
    {
        return empty($this->getDocument());
    }

    /**
     * @return DocumentRepository
     */
    public static function getDocRepo(): DocumentRepository
    {
        if (self::$docRepo === null) {
            self::$docRepo = new DocumentRepository(static::class, static::TARGET_TYPE);
        }

        return self::$docRepo;
    }
}
