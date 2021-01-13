<?php

namespace App\Bundles\Cron\Supervisor;

use App\Bundles\Cron\Contracts\Supervisor;
use ArtARTs36\ShellCommand\ShellCommand;

class SelfSupervisor implements Supervisor
{
    public function update(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), '')
            ->addParameter('supervisorctl update')
            ->addParameter('supervisorctl restart horizon:*')
            ->addParameter('supervisorctl restart cron:*')
            ->execute();
    }

    public function start(): void
    {
        ShellCommand::getInstanceWithMoveDir(base_path(), '')
            ->addParameter('/usr/bin/supervisord -c /etc/supervisor/supervisord.conf')
            ->execute();
    }
}
