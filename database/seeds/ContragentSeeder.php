<?php

use App\Bundles\Contragent\Support\Finder;
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
            $contragent = new App\Models\Contragent();

            $name = \App\Based\Support\RuFaker::fio();

            $contragent->title = $name;
            $contragent->full_title = $name;
            $contragent->full_title_with_opf = \App\Based\Support\RuFaker::withOpf($name);
            $contragent->inn = rand(11111111, 99999999999);
            $contragent->kpp = rand(11111111, 99999999999);
            $contragent->ogrn = rand(11111111, 99999999999);
            $contragent->okato = rand(11111111, 99999999999);
            $contragent->oktmo = rand(11111111, 99999999999);
            $contragent->okved = rand(11111111, 99999999999);
            $contragent->okved_type = rand(1, 99);
            $contragent->address = \App\Based\Support\RuFaker::getGenerator()->address;
            $contragent->address_postal = rand(111111, 999999);
            $contragent->status = 0;
            $contragent->save();

            $contragentIds[] = $contragent->id;
        }

        foreach ($contragentIds as $id) {
            $this->createManager($id);
        }
    }

    private function createManager(int $contragentId): void
    {
        for ($i = 0; $i < rand(1, 5); $i++) {
            $gender = \App\Based\Support\RuFaker::gender();

            $manager = new Contragent\ContragentManager();
            $manager->name = \App\Based\Support\RuFaker::name($gender);
            $manager->patronymic = \App\Based\Support\RuFaker::patronymic($gender);
            $manager->family = \App\Based\Support\RuFaker::family($gender);
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
            app(Finder::class)->findByInnOrOgrn($datum->inn);
        }
    }
}
