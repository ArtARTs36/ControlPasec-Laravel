<?php

namespace App\Bundles\Vocab\Services;

use App\Bundles\Vocab\Contracts\NameInclinator;
use App\Bundles\Vocab\Models\VocabWord;
use Illuminate\Support\Collection;
use App\Bundles\Vocab\Contracts\WordService as MainContract;

final class WordService implements MainContract
{
    private $inclinator;

    public function __construct(NameInclinator $inclinator)
    {
        $this->inclinator = $inclinator;
    }

    public function getOrCreateByNominatives(array $words): Collection
    {
        $declensions = $this->getByNominatives(...$words);

        foreach ($words as $word) {
            if ($declensions->offsetExists($word)) {
                continue;
            }

            $declensions->put($word, $this->inclinator->decline($word));
        }

        return $declensions;
    }

    public function getByNominatives(string ...$words): Collection
    {
        return VocabWord::query()
            ->whereIn(VocabWord::FIELD_NOMINATIVE, $words)
            ->get()
            ->pluck(null, VocabWord::FIELD_NOMINATIVE);
    }
}
