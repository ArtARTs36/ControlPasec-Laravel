<?php

namespace App\Bundles\Landing\Services;

use App\Bundles\Landing\Events\FeedBackCreated;
use App\Bundles\Landing\Http\Requests\StoreFeedBack;
use App\Bundles\Landing\Models\FeedBack;

class FeedBackCreator
{
    public function fromRequest(StoreFeedBack $request): FeedBack
    {
        $feedback = new FeedBack();

        $feedback->fillOfRequest($request);
        $feedback->ip = $request->getClientIp();

        $feedback->save();

        event(new FeedBackCreated($feedback));

        return $feedback;
    }
}
