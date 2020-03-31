<?php

namespace App\Http\Resource;

use App\Models\Dialog\Dialog;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DialogsListResource
 * @mixin Dialog
 */
class DialogsListResource extends JsonResource
{
    public function toArray($request): array
    {
        $interUser = $this->getInterUser();

        $message = $this->messages->last()->toArray();

        return [
            'id' => $this->id,
            'last_message' => array_merge(
                $message,
                [
                    'updated_at' => (new \DateTime($message['updated_at']))->format('d.m.y H:i'),
                ]
            ),
            'inter_user' => [
                'id' => $interUser->id,
                'full_name' => $interUser->getFullName(),
                'avatar_url' => $interUser->getAvatarUrl(),
            ],
        ];
    }
}
