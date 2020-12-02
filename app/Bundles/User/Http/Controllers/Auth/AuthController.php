<?php

namespace App\Bundles\User\Http\Controllers\Auth;

use App\Http\Actions\UserMeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resource\UserResource;
use App\Repositories\UserRepository;
use App\Services\Jwt;
use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * Issue a JWT token when valid login credentials are
     * presented.
     *
     * @param AuthRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/api/auth/token/issue",
     *      operationId="authenticationUser",
     *      tags={"Authentication"},
     *      summary="Authentication user",
     *      description="Get authenticated user meta & token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="password", type="string"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Schema(ref="#/components/schemas/User"),
     *              ),
     *              @OA\Property(property="token", type="string"),
     *              @OA\Property(property="token_ttl", type="integer"),
     *          ),
     *      ),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function issueToken(AuthRequest $request, UserRepository $repository)
    {
        /** Determine if the user has too many failed login attempts. */
        if ($this->hasTooManyLoginAttempts($request)) {
            /** Fire an event when a lockout occurs. */
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = array_merge($request->only('email', 'password'), [
            User::FIELD_IS_ACTIVE => true
        ]);

        if ($isAuthorize = $this->guard()->attempt($credentials)) {
            if ($this->guard()->check() !== true && $user = $repository->findByEmail($credentials['email'])) {
                $this->guard()->login($user);
            }

            $token = isset($user)
                ? JWTAuth::fromUser($user)
                : $isAuthorize;

            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return UserResource
     *
     * @OA\Post(
     *      path="/auth/login-as/{user}",
     *      operationId="authenticationAsUser",
     *      tags={"Authentication"},
     *      security={{"bearerAuth": {}}},
     *      summary="Authenticate as user",
     *      description="Get authenticated user meta & token",
     *      @OA\Parameter(
     *          name="user",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  @OA\Schema(ref="#/components/schemas/User"),
     *              ),
     *              @OA\Property(property="token", type="string"),
     *              @OA\Property(property="token_ttl", type="integer"),
     *          ),
     *      ),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function loginAs(User $user, Request $request): UserResource
    {
        $this->guard()->logout();
        $this->guard()->login($user);

        return $this->sendLoginResponse($request, JWTAuth::fromUser($user));
    }

    /**
     * Return the token and current user authenticated.
     *
     * @param Request $request
     * @param string $token
     * @return UserResource
     */
    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        $token_ttl = (new Jwt($token))->getTokenTTL();

        return UserMeAction::get()->additional(compact('token', 'token_ttl'));
    }

    /**
     * Return error message after determining invalid credentials.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $message = Lang::get('auth.failed');

        return response()->json($message, HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = Lang::get('auth.throttle', ['seconds' => $seconds]);

        return response()->json($message, HttpResponse::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * Revoke the user's token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/auth/token/revoke",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      security={{"bearerAuth": {}}},
     *      summary="Logout user",
     *      description="Revoke token authenticated user",
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function revokeToken()
    {
        Auth::guard('api')->logout();

        return response()->json([], HttpResponse::HTTP_NO_CONTENT);
    }

    /**
     * Refresh the user's token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(Request $request)
    {
        $token = $this->guard()->refresh();

        $token_ttl = (new Jwt($token))->getTokenTTL();

        return response()->json(compact('token', 'token_ttl'));
    }

    public function username(): string
    {
        return 'email';
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
