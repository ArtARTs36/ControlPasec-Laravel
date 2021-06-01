<?php

class SupplyStatusSeeder extends CommonSeeder
{
    public function run(): void
    {
        /** @var \App\Bundles\Supply\Repositories\SupplyStatusRepository $repo */
        $repo = app(\App\Bundles\Supply\Repositories\SupplyStatusRepository::class);

        $statuses = [
            'new' => 'Новая поставка',
            'confirmed' => 'Поставка утверждена',
            'in_progress' => 'Поставка выполняется',
            'complete' => 'Поставка завершена',
        ];

        foreach ($statuses as $slug => $title) {
            $repo->create($title, $slug);
        }
    }
}
