<?php

namespace App\Bundles\Landing\Http\Resources;

use App\Bundles\Landing\Models\FeedBack;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FeedBack
 */
class FeedBackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'people_title' => $this->people_title,
            'people_email' => $this->people_email,
            'people_phone' => $this->people_phone,
            'message' => $this->message,
        ];
    }
}
