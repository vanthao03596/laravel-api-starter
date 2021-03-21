<?php

namespace App\Http\Controllers\API;

use App\Models\RefreshToken;
use Illuminate\Http\JsonResponse;
use Jiannei\Response\Laravel\Support\Facades\Response;

class RefreshTokenController
{
    public function __invoke(): JsonResponse
    {
        $refreshToken = request('refresh_token');

        if (!$refreshToken) {
            Response::errorUnauthorized();
        }

        $token = RefreshToken::findToken($refreshToken);

        if (!$token){
            Response::errorUnauthorized();
        }

        if ($token->isExpired()) {
            Response::errorUnauthorized();
        }

        if (!$tokenable = $token->tokenable) {
            Response::errorUnauthorized();
        }

        $token = auth()->tokenById($tokenable->id);

        return Response::success(
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]
        );
    }
}
