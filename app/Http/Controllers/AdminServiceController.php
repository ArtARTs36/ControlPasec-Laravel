<?php

namespace App\Http\Controllers;

use App\Services\AdminService\AdminServiceAccess;
use Illuminate\Http\Request;

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

        AdminServiceAccess::give($request->getClientIp());

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
