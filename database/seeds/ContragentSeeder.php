<?php

use App\Models\Contragent;
use App\Parsers\DaDataParser\DaDataParser;

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

        if (env('ENV_TYPE') == 'prod') {
            $this->seedExternalAgents();
        } else {
            $this->randomData(100);
        }
    }

    public function randomData($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $contragent = new App\Models\Contragent();

            $name = $this->faker()->name;

            $contragent->title = $name;
            $contragent->full_title = $name . ' '. $name;
            $contragent->full_title_with_opf = $name . ' '. $name . $this->faker()->lastName;
            $contragent->inn = rand(11111111, 99999999999);
            $contragent->kpp = rand(11111111, 99999999999);
            $contragent->ogrn = rand(11111111, 99999999999);
            $contragent->okato = rand(11111111, 99999999999);
            $contragent->oktmo = rand(11111111, 99999999999);
            $contragent->okved = rand(11111111, 99999999999);
            $contragent->okved_type = rand(1, 99);
            $contragent->address = $this->faker()->address;
            $contragent->address_postal = rand(111111, 999999);
            $contragent->status = 0;
            $contragent->save();
        }
    }

    /**
     * Внести контрагентов из внешней системы
     */
    public function seedExternalAgents()
    {
        $data = $this->getStringsOfResource('external_contragents_inn');

        foreach ($data as $datum) {
            DaDataParser::findContragentByInnOrOGRN($datum->inn);
        }
    }
}
