<?php

namespace App\Bundles\Vocab\Services;

use App\Bundles\Vocab\Models\VocabWord;
use ArtARTs36\Morpher\Entities\Noun;
use ArtARTs36\Morpher\Morpher;

class NameInclinator
{
    protected $morpher;

    public function __construct(Morpher $morpher)
    {
        $this->morpher = $morpher;
    }

    /**
     * Склонить слова по падежам
     */
    public function decline(string $name): VocabWord
    {
        return $this->create($noun = $this->morpher->declineNoun($name), $this->bringType($noun));
    }

    protected function bringType(Noun $word): int
    {
        if (! $word->isFamilyExists()) {
            return VocabWord::TYPE_UNKNOWN;
        }

        $family = $word->family();

        if ($family->patronymic()) {
            return VocabWord::TYPE_PATRONYMIC;
        } elseif ($family->lastName()) {
            return VocabWord::TYPE_FAMILY;
        }

        return VocabWord::TYPE_NAME;
    }

    protected function create(Noun $word, int $type): VocabWord
    {
        $this->fill($vocab = new VocabWord(), $word, $type);

        $vocab->save();

        return $vocab;
    }

    protected function fill(VocabWord $vocab, Noun $word, int $type): VocabWord
    {
        $vocab->type = $type;
        $vocab->nominative = $word->nominative();
        $vocab->dative = $word->dative();
        $vocab->genitive = $word->genitive();
        $vocab->instrumental = $word->instrumental();
        $vocab->prepositional = $word->prepositional();

        if ($word->isPluralExists()) {
            $vocab->plural_nominative = $word->pluralNominative();
            $vocab->plural_dative = $word->pluralDative();
            $vocab->plural_genitive = $word->pluralGenitive();
            $vocab->plural_instrumental = $word->pluralInstrumental();
            $vocab->plural_prepositional = $word->pluralPrepositional();
        }

        return $vocab;
    }
}
