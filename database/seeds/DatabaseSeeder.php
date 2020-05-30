<?php

use Illuminate\Database\Seeder;

require_once 'vendor/dba/controltime/database/seeds/WorkConditionSeeder.php';
require_once 'vendor/dba/controltime/database/seeds/TimeSeeder.php';

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->users();
        $this->vocabs();
        $this->contragents();

        $this->call(BankRequisitesSeeder::class);

        $this->call(ProductSeeder::class);
        $this->contracts();

        $this->documents();

        $this->call(CurrencyCourseSeeder::class);

        $this->call(ExternalNewsSourceSeeder::class);
        $this->call(ExternalNewsSeeder::class);

        $this->call(ModelTypeSeeder::class);

        $this->textDataParser();

        $this->call(SyncWithExternalSystemTypeSeeder::class);

        $this->call(SupplySeeder::class);

        $this->call(UserNotificationSeeder::class);

        $this->call(EmployeeSeeder::class);
        $this->call(WorkConditionSeeder::class);
        $this->call(TimeSeeder::class);
    }

    private function vocabs(): void
    {
        $this->call(VocabWordSeeder::class);
        $this->call(VocabBankSeeder::class);
        $this->call(VocabQuantityUnitSeeder::class);
        $this->call(SizeOfUnitSeeder::class);
        $this->call(VocabCurrencySeeder::class);
        $this->call(VocabPackageTypeSeeder::class);
        $this->call(VocabGosStandardSeeder::class);
    }

    private function contragents(): void
    {
        $this->call(ContragentSeeder::class);
        $this->call(MyContragentSeeder::class);
        $this->call(ContragentGroupSeeder::class);
    }

    private function users(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }

    private function contracts(): void
    {
        $this->call(ContractTemplateSeeder::class);
        $this->call(ContractSeeder::class);
    }

    private function textDataParser(): void
    {
        $this->call(TextDataParserComponentSeeder::class);
        $this->call(VariableDefinitionSeeder::class);
    }

    private function documents(): void
    {
        $this->call(DocumentExtensionSeeder::class);
        $this->call(DocumentLoaderSeeder::class);
        $this->call(DocumentTypeSeeder::class);
    }
}
