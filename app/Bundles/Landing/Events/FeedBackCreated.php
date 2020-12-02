<?php

namespace App\Bundles\Landing\Events;

use App\Bundles\Landing\Models\FeedBack;
use App\Events\BaseEvent;

final class FeedBackCreated extends BaseEvent
{
    public $feedback;

    public function __construct(FeedBack $feedBack)
    {
        $this->feedback = $feedBack;
    }

    public function getFeedBack(): FeedBack
    {
        return $this->feedback;
    }
}
