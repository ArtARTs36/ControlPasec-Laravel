<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ContragentSeeder::class);

        $this->call(VocabBankSeeder::class);
        $this->call(BankRequisitesSeeder::class);
        $this->call(MyContragentSeeder::class);
        $this->call(SizeOfUnitSeeder::class);
        $this->call(VocabCurrencySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ContractTemplateSeeder::class);
    }
}
