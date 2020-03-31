<?php

namespace App\Http\Resource;

use App\Models\Dialog\Dialog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class DialogResource
 * @mixin Dialog
 */
class DialogResource extends JsonResource
{
    public function toArray($request): array
    {
        $interUser = $this->getInterUser();

        $page = $this->getPage($request);

        $messages = $this->messages()->latest('created_at')
            ->paginate(10, ['*'], 'DialogView', $page);

        return [
            'id' => $this->id,
            'inter_user' => [
                'id' => $interUser->id,
                'full_name' => $interUser->getFullName(),
                'avatar_url' => $interUser->getAvatarUrl(),
            ],
            'messages' => DialogMessageResource::collection($messages),
            'meta' => [
                'total' => $messages->total(),
                'last_page' => $messages->lastPage(),
            ],
        ];
    }

    private function getPage(Request $request): int
    {
        $parse = explode("/", $request->getRequestUri());
        $pageParse = explode('page-', end($parse));

        return (int) end($pageParse);
    }
}
