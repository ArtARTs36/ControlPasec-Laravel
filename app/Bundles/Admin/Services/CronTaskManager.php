<?php

namespace App\Bundles\Admin\Services;

use Studio\Totem\Frequency;
use Studio\Totem\Task;

class CronTaskManager
{
    /**
     * @param array<string> $times
     */
    public function createDailyAt(string $name, string $command, array $times): Task
    {
        Task::unsetEventDispatcher();

        /** @var Task $task */
        $task = Task::query()->create([
            'description'       => $name,
            'command'           => $command,
            'is_active'         => true,
            'timezone'          => config('app.timezone'),
            'auto_cleanup_type' => 'results',
        ]);

        /** @var Frequency $frequency */
        $frequency = $task->frequencies()->create([
            'label' => 'Daily at',
            'interval' => 'dailyAt',
        ]);

        foreach ($times as $time) {
            $frequency->parameters()->create([
                'name' => 'at',
                'value' => $time,
            ]);
        }

        return $task;
    }
}
