<?php

namespace App\Events;

use App\Models\Landing\LandingFeedBack;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LandingFeedBackCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $feedback;

    public function __construct(LandingFeedBack $feedBack)
    {
        $this->feedback = $feedBack;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
