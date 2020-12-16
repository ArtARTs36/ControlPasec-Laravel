<?php

namespace App\Bundles\Landing\Events;

use App\Bundles\Landing\Models\FeedBack;
use App\Based\Events\Event;

final class FeedBackCreated extends Event
{
    private $feedback;

    public function __construct(FeedBack $feedBack)
    {
        $this->feedback = $feedBack;
    }

    public function getFeedBack(): FeedBack
    {
        return $this->feedback;
    }
}
