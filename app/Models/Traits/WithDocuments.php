<?php

namespace App\Models\Traits;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait WithDocuments
{
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
}
