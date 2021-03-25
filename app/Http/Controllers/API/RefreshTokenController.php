<?php

namespace App\Http\Controllers\API;

use App\Models\RefreshToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Jiannei\Response\Laravel\Support\Facades\Response;

class RefreshTokenController
{
    public function __invoke(): JsonResponse
    {
        $refreshToken = $this->tokenFromRequest();

        if (! $refreshToken) {
            Response::errorUnauthorized();
        }

        $token = RefreshToken::findToken($refreshToken);

        if (! $token) {
            Response::errorUnauthorized();
        }

        if ($token->isExpired()) {
            Response::errorUnauthorized();
        }

        if (! $tokenable = $token->tokenable) {
            Response::errorUnauthorized();
        }

        $token = Auth::tokenById($tokenable->id);

        return Response::success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ]
        );
    }

    private function tokenFromRequest()
    {
        if (Cookie::has('refresh_token')) {
            return Cookie::get('refresh_token');
        }

        return request('refresh_token');
    }
}
