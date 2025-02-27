<?php

namespace App\Bundles\User\Http\Controllers\Auth;

use App\Bundles\User\Contracts\Tokenizer;
use App\Bundles\User\Http\Resources\UserResource;
use App\Bundles\User\Http\Actions\FetchMyUser;
use App\Based\Contracts\Controller;
use App\Bundles\User\Http\Requests\AuthRequest;
use App\Bundles\User\Repositories\UserRepository;
use App\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tymon\JWTAuth\JWT;

final class AuthController extends Controller
{
    use ThrottlesLogins;

    private $tokenizer;

    public function __construct(Tokenizer $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

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
    public function issueToken(AuthRequest $request, UserRepository $repository, JWT $jwt)
    {
        /** Determine if the user has too many failed login attempts. */
        if ($this->hasTooManyLoginAttempts($request)) {
            /** Fire an event when a lockout occurs. */
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = array_merge($request->only([User::FIELD_EMAIL, User::FIELD_PASSWORD]), [
            User::FIELD_IS_ACTIVE => true,
        ]);

        if ($isAuthorize = $this->guard()->attempt($credentials)) {
            if ($this->guard()->check() !== true &&
                $user = $repository->findByEmail($credentials[User::FIELD_EMAIL])) {
                $this->guard()->login($user);
            }

            $token = isset($user)
                ? $jwt->fromUser($user)
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
    public function loginAs(User $user, Request $request, JWT $jwt): UserResource
    {
        $this->guard()->logout();
        $this->guard()->login($user);

        return $this->sendLoginResponse($request, $jwt->fromUser($user));
    }

    /**
     * Return the token and current user authenticated.
     */
    protected function sendLoginResponse(Request $request, string $token): UserResource
    {
        $this->clearLoginAttempts($request);

        $token_ttl = $this->tokenizer->getTokenTTL($token);

        return (new FetchMyUser())
            ->toResource()
            ->additional(compact('token', 'token_ttl'));
    }

    /**
     * Return error message after determining invalid credentials.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $message = Lang::get('auth.failed');

        return response()->json($message, HttpResponse::HTTP_UNAUTHORIZED);
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @tag Auth
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
     * @tag Auth
     */
    public function revokeToken()
    {
        Auth::guard('api')->logout();

        return response()->json([], HttpResponse::HTTP_NO_CONTENT);
    }

    /**
     * @tag Auth
     */
    public function refreshToken(Request $request)
    {
        return response()->json([
            'token' => $token = $this->guard()->refresh(),
            'token_ttl' => $this->tokenizer->getTokenTtl($token),
        ]);
    }

    public function username(): string
    {
        return User::FIELD_EMAIL;
    }

    protected function guard()
    {
        return Auth::guard('api');
    }
}
