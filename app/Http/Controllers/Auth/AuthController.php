<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'registration']]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="loginUser",
     *      tags={"Authentication"},
     *      security={{"bearerAuth": {}}},
     *      summary="Login User",
     *      description="Revoke token authenticated user",
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          required=true
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true
     *      ),
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not found"),
     *      @OA\Response(response=401, description="Uncorrect data"),
     * )
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * User registration
     */
    public function registration()
    {
        $name = request('name');
        $email = request('email');
        $password = request('password');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return response()->json(['message' => 'Successfully registration!']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Revoke the user's token.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *      path="/auth/logout",
     *      operationId="logoutUser",
     *      tags={"Authentication"},
     *      security={{"bearerAuth": {}}},
     *      summary="Logout user",
     *      description="Revoke token authenticated user",
     *      @OA\Response(response=200, description="successful operation"),
     *      @OA\Response(response=404, description="Resource Not found"),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
