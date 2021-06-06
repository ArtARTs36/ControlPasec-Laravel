<?php

use Illuminate\Database\Seeder;

class TotemTaskSeeder extends Seeder
{
    public function run(): void
    {
        /** @var \App\Bundles\Admin\Services\CronTaskManager $manager */
        $manager = app(\App\Bundles\Admin\Services\CronTaskManager::class);

        //

        $manager->createDailyAt('Получить курсы валют', 'currency-course:now', ['12:00', '18:00']);
        $manager->createDailyAt(
            'Получить новости из внешних источников',
            'external-news:fetch',
            ['12:00', '18:00']
        );

        $manager->createMonthly(
            'Получить погоду за текущий месяц',
            'weather:fetch current-month'
        );

        $manager->createDailyAt(
            'Обновить таблицу спам IP',
            'blockip:get-new-ips',
            ['23:00']
        );

        $manager->createSunday(
            'Загрузить выходные дни на следующую неделю',
            'holiday:fetch next-week'
        );

        $manager->createDailyAt(
            'Создание снэпшота системы',
            'system:create-snapshot',
            ['12:00', '22:00']
        );
    }
}
