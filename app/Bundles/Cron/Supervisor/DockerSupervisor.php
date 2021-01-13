<?php

namespace App\Bundles\Cron\Supervisor;

use ArtARTs36\ShellCommand\ShellCommand;

class DockerSupervisor
{
    public function update(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), '')
            ->addParameter('sh scripts/docker/supervisor-update.sh')
            ->execute();
    }

    public function start(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), '')
            ->addParameter('sh scripts/docker/supervisor-start.sh')
            ->execute();
    }
}
