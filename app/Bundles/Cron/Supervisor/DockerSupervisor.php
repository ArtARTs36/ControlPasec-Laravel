<?php

namespace App\Bundles\Cron\Supervisor;

use App\Bundles\Cron\Contracts\Supervisor;
use ArtARTs36\ShellCommand\ShellCommand;

class DockerSupervisor implements Supervisor
{
    public function update(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), 'sh')
            ->addParameter('scripts/docker/supervisor-update.sh')
            ->execute();
    }

    public function start(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), 'sh')
            ->addParameter('scripts/docker/supervisor-start.sh')
            ->execute();
    }
}
