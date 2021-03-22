<?php

namespace App\Http\Controllers\API;

use App\Enums\ResponseCodeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Resources\UserResource;
use Jiannei\Response\Laravel\Support\Facades\Response;

class AuthorizationController extends Controller
{
    public function store(LoginRequest $loginRequest)
    {
        $credentials = $loginRequest->only(['email', 'password']);

        if (!$token = $this->guard()->attempt($credentials)) {
            Response::errorUnauthorized();
        }

        $refreshToken = $this->guard()->user()->createRefreshToken()->plainTextToken;

        return $this->respondWithToken($token, $refreshToken);
    }

    public function show()
    {
        $user = $this->guard()->userOrFail();

        return Response::success(UserResource::make($user));
    }

    public function destroy()
    {
        $this->guard()->logout();

        return Response::noContent();
    }


    protected function respondWithToken(string $token, string $refreshToken)
    {
        return Response::success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->guard()->factory()->getTTL() * 60,
                'refresh_token' => $refreshToken,
                'user' => UserResource::make($this->guard()->user())
            ],
            '',
            ResponseCodeEnum::SERVICE_LOGIN_SUCCESS
        );
    }

    protected function guard()
    {
        return auth();
    }
}
