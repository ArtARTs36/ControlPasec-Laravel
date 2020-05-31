<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminServiceController extends Controller
{
    /**
     * @todo сделать модель AdminService
     * @param Request $request
     * @return array
     */
    public function toHorizon(Request $request)
    {
        $user = auth()->user();
        if ($user === null) {
            abort(403);
        }

        /** @todo костыль */
        session()->push('user_id', $user->id);

        return $this->answer(
            $request->getSchemeAndHttpHost() . '/horizon',
            'horizon'
        );
    }

    public function answer(string $url, string $name): array
    {
        return [
            'service_url' => $url,
            'service_name' => $name,
        ];
    }
}
