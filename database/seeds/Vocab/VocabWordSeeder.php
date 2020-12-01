<?php

/**
 * Class VocabWordSeeder
 *
 * Наполнитель для словаря
 */
class VocabWordSeeder extends CommonSeeder
{
    public function run()
    {
        $this->fillModel(\App\Bundles\Vocab\Models\VocabWord::class, 'data_vocab_words');
    }
}
