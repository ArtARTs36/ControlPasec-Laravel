<?php

use App\Models\Contragent;

class ContragentSeeder extends CommonSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fillModel(Contragent::class, 'data_contragent');

        if (env('APP_ENV') == 'production') {
            $this->seedExternalAgents();
        } else {
            $this->randomData(100);
        }
    }

    public function randomData($count)
    {
        $contragentIds = [];
        for ($i = 0; $i < $count; $i++) {
            $contragent = factory(Contragent::class)->create();

            $contragentIds[] = $contragent->id;
        }

        foreach ($contragentIds as $id) {
            $this->createManager($id);
        }
    }

    private function createManager(int $contragentId): void
    {
        for ($i = 0; $i < rand(1, 5); $i++) {
            $gender = \App\Support\RuFaker::gender();

            $manager = new Contragent\ContragentManager();
            $manager->name = \App\Support\RuFaker::name($gender);
            $manager->patronymic = \App\Support\RuFaker::patronymic($gender);
            $manager->family = \App\Support\RuFaker::family($gender);
            $manager->contragent_id = $contragentId;
            $manager->save();
        }
    }

    /**
     * Внести контрагентов из внешней системы
     */
    public function seedExternalAgents()
    {
        $data = $this->getStringsOfResource('external_contragents_inn');

        foreach ($data as $datum) {
            app(\App\Bundles\Contragent\Support\Finder::class)->findByInnOrOrgn($datum->inn);
        }
    }
}
