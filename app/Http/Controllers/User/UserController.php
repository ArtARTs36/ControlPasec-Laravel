<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resource\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     *
     * @return UserResource
     *
     * @OA\Get(
     *      path="/api/me",
     *      operationId="User me Profile",
     *      tags={"Me Current User"},
     *      description="Get authenticated user meta",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Schema(ref="#/components/schemas/User"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function me()
    {
        if (auth()->user() === null) {
            abort(403);
        }

        return new UserResource(auth()->user());
    }
}
