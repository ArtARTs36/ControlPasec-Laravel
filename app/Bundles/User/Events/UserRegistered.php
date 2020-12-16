<?php

namespace App\Bundles\User\Events;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        parent::__construct($user);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
