<?php

namespace App\Interfaces;

use App\Models\Document\Document;
use App\Repositories\DocumentRepository;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface ModelWithDocuments
{
    public function getDocument(): ?Document;

    public function documents(): BelongsToMany;

    public function isExistsDocument(): bool;

    public function isNotExistsDocument(): bool;

    public static function getDocRepo(): DocumentRepository;
}
