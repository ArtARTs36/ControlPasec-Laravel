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
        $this->call(VocabWordSeeder::class);
        $this->call(ContragentSeeder::class);
        $this->call(MyContragentSeeder::class);

        $this->call(VocabBankSeeder::class);
        $this->call(BankRequisitesSeeder::class);

        $this->call(VocabQuantityUnitSeeder::class);
        $this->call(SizeOfUnitSeeder::class);
        $this->call(VocabCurrencySeeder::class);

        $this->call(VocabGosStandardSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ContractTemplateSeeder::class);

        $this->call(DocumentExtensionSeeder::class);
        $this->call(DocumentLoaderSeeder::class);
        $this->call(DocumentTypeSeeder::class);

        $this->call(SupplySeeder::class);

        $this->call(DocumentSeeder::class);
        $this->call(CurrencyCourseSeeder::class);

        $this->call(ExternalNewsSourceSeeder::class);
        $this->call(ExternalNewsSeeder::class);
    }
}
