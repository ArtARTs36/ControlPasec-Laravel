<?php

use Illuminate\Database\Seeder;

class ContragentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMyAgent();

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

    public function createMyAgent()
    {
        $contragent = new App\Models\Contragent();
        $contragent->title = 'Украинский ВН';
        $contragent->full_title = 'Украинский ВН';
        $contragent->full_title_with_opf = 'Украинский ВН';
        $contragent->inn = 361200066399;
        $contragent->status = 0;
        $contragent->save();
    }
}
