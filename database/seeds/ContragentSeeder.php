<?php

use App\Models\Contragent;

class ContragentSeeder extends MyDataBaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fillModel(Contragent::class, 'data_contragent');

        $this->seedExternalAgents([
            '3612006131', // МКОУ Писаревская СОШ
            '3629004693', // МКОУ Таловская СОШ
            '3612005716' // МКОУ Охрозаводская СОШ
        ]);
    }

    public function seedExternalAgents($inns)
    {
        foreach ($inns as $inn)
        {
            \App\Parsers\DaDataParser\DaDataParser::findContragentByInnOrOGRN($inn);
        }
    }
}
