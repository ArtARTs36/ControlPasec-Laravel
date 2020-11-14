<?php

namespace App\Events;

use App\Models\Landing\LandingFeedBack;

class FeedBackCreated extends Event
{
    public $feedback;

    public function __construct(LandingFeedBack $feedBack)
    {
        $this->feedback = $feedBack;
    }
}
