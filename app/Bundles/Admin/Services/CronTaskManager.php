<?php

namespace App\Bundles\Admin\Services;

use Illuminate\Database\Eloquent\Model;
use Studio\Totem\Frequency;
use Studio\Totem\Task;

class CronTaskManager
{
    /**
     * @param array<string> $times
     */
    public function createDailyAt(string $name, string $command, array $times): Task
    {
        $task = $this->createTask($name, $command);

        /** @var Frequency $frequency */
        $frequency = $task->frequencies()->create([
            'label' => 'Daily at',
            'interval' => 'dailyAt',
        ]);

        $this->applyParameters($frequency, 'at', $times);

        return $task;
    }

    public function createSunday(string $name, string $command): Task
    {
        $task = $this->createTask($name, $command);

        $task->frequencies()->create([
            'label' => 'Every Sunday',
            'interval' => 'sundays',
        ]);

        return $task;
    }

    public function createMonthly(string $name, string $command): Task
    {
        $task = $this->createTask($name, $command);

        $task->frequencies()->create([
            'label' => 'Monthly',
            'interval' => 'monthly',
        ]);

        return $task;
    }


    protected function createTask(string $name, string $command): Task
    {
        Task::unsetEventDispatcher();

        return Task::query()->create([
            'description'       => $name,
            'command'           => $command,
            'is_active'         => true,
            'timezone'          => config('app.timezone'),
            'auto_cleanup_type' => 'results',
        ]);
    }

    protected function applyParameters(Frequency $frequency, string $name, array $times): void
    {
        foreach ($times as $time) {
            $frequency->parameters()->create([
                'name' => $name,
                'value' => $time,
            ]);
        }
    }
}
