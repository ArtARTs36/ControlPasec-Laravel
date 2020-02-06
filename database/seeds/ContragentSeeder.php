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
        $contragent = new App\Models\Contragent();
        $contragent->title = 'Украинский ВН';
        $contragent->full_title = 'Украинский ВН';
        $contragent->full_title_with_opf = 'Украинский ВН';
        $contragent->inn = 361200066399;
        $contragent->status = 0;
        $contragent->save();
    }
}
