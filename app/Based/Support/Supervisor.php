<?php

namespace App\Based\Support;

use ArtARTs36\ShellCommand\ShellCommand;

class Supervisor
{
    public function update(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), '')
            ->addParameter('sh scripts/docker/supervisor-update.sh')
            ->execute();
    }
}
