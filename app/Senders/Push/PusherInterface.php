<?php

namespace App\Senders\Push;

/**
 * Interface PusherInterface
 * @package App\Senders
 */
interface PusherInterface
{
    /**
     * @param Push $push
     * @return mixed
     */
    public function push(Push $push);

    /**
     * @param Push $push
     * @throws PushException
     * @return mixed
     */
    public function pushOrFail(Push $push);
}
