<?php

use App\Models\Vocab\VocabBank;

/**
 * Class VocabBankSeeder
 *
 * Наполнитель для справочника банков
 */
class VocabBankSeeder extends CommonSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fillModel(VocabBank::class, 'data_vocab_bank');
        if (env('APP_ENV') == 'local') {
            $this->randomData(100);
        }
    }

    /**
     * @param int $count
     */
    private function randomData(int $count): void
    {
        for ($i = 0; $i < $count; $i++) {
            $bank = new VocabBank();
            $bank->short_name = $this->faker()->firstNameMale;
            $bank->full_name = $bank->short_name . ' ' . $this->faker()->lastName;
            $bank->bik = rand(11111111, 99999999);
            $bank->score = $this->faker()->bankAccountNumber;

            $bank->save();
        }
    }
}
