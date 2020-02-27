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
        $this->fillModel(\App\Models\Vocab\VocabWord::class, 'data_vocab_words');
    }
}
