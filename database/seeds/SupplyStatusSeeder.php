<?php

class SupplyStatusSeeder extends CommonSeeder
{
    public function run(): void
    {
        /** @var \App\Bundles\Supply\Repositories\SupplyStatusRepository $repo */
        $repo = app(\App\Bundles\Supply\Repositories\SupplyStatusRepository::class);

        /** @var \App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository $transitionsRepo */
        $transitionsRepo = app(\App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository::class);

        $statuses = [
            'new' => 'Новая поставка',
            'discussion_with_customer' => 'Ведется обсуждение с заказчиком',
            'confirmed' => 'Поставка утверждена',
            'canceled' => 'Поставка отклонена',
            'wait_repeat_discussion' => 'Поставка ожидает повторного обсуждения',
            'wait_payment' => 'Ожидается оплата',
            'in_progress' => 'Поставка выполняется',
            'completed' => 'Поставка завершена',
            'payment_not_provided' => 'Оплата не предоставлена',
            'payment_provided' => 'Оплата получена',
        ];

        $instances = [];

        foreach ($statuses as $slug => $title) {
            $instances[$slug] = $repo->create($title, $slug);
        }

        //

        $transitionsRepo->create(
            $instances['new'],
            $instances['discussion_with_customer'],
            'Создать поставку'
        );

        $transitionsRepo->create(
            $instances['discussion_with_customer'],
            $instances['confirmed'],
            'Подтвердить поставку'
        );

        $transitionsRepo->create(
            $instances['discussion_with_customer'],
            $instances['canceled'],
            'Отклонить поставку'
        );

        $transitionsRepo->create(
            $instances['discussion_with_customer'],
            $instances['wait_repeat_discussion'],
            'Обсудить повторно'
        );

        $transitionsRepo->create(
            $instances['wait_repeat_discussion'],
            $instances['canceled'],
            'Отклонить поставку'
        );

        $transitionsRepo->create(
            $instances['payment_not_provided'],
            $instances['wait_repeat_discussion'],
            'Обсудить повторно'
        );

        $transitionsRepo->create(
            $instances['wait_repeat_discussion'],
            $instances['confirmed'],
            'Подтвердить поставку'
        );

        $transitionsRepo->create(
            $instances['confirmed'],
            $instances['wait_payment'],
            'Ожидать оплату'
        );

        $transitionsRepo->create(
            $instances['wait_payment'],
            $instances['payment_not_provided'],
            'Подтвердить неоплату'
        );

        $transitionsRepo->create(
            $instances['wait_payment'],
            $instances['payment_provided'],
            'Подтвердить оплату'
        );

        $transitionsRepo->create(
            $instances['payment_provided'],
            $instances['in_progress'],
            'Отправить поставку'
        );

        $transitionsRepo->create(
            $instances['in_progress'],
            $instances['completed'],
            'Завершить поставку'
        );
    }
}
