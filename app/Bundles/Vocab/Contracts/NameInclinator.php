<?php

namespace App\Bundles\Vocab\Contracts;

use App\Bundles\Vocab\Models\VocabWord;

interface NameInclinator
{
    public function decline(string $name): VocabWord;
}
