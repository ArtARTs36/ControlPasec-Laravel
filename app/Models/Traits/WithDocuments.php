<?php

namespace App\Models\Traits;

use App\Models\Document\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait WithDocuments
{
    private static $docRepo = null;

    /**
     * Получить список документов
     * @return BelongsToMany
     */
    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class);
    }

    /**
     * Получить первый документ
     * @return Document|null
     */
    public function getDocument(): ?Document
    {
        return $this->documents[0] ?? null;
    }

    public function isExistsDocument(): bool
    {
        return isset($this->documents[0]);
    }

    public function isNotExistsDocument(): bool
    {
        return !isset($this->documents[0]);
    }

    public static function getDocRepo(): DocumentRepository
    {
        if (self::$docRepo === null) {
            self::$docRepo = new DocumentRepository(static::class, static::TARGET_TYPE);
        }

        return self::$docRepo;
    }
}
