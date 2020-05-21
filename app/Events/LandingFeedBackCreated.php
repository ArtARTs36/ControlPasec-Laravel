<?php

namespace App\Events;

use App\Models\Landing\LandingFeedBack;

class LandingFeedBackCreated extends BaseEvent
{
    public $feedback;

    public function __construct(LandingFeedBack $feedBack)
    {
        $this->feedback = $feedBack;
    }
}
