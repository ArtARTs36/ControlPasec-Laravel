<?php

namespace App\Interfaces;

use App\Models\Document\Document;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface ModelWithDocuments
{
    public function getDocument(): ?Document;

    public function documents(): BelongsToMany;

    public function isExistsDocument(): bool;
}
