<?php

namespace App\Http\Controllers\API;

use App\Enums\ResponseCodeEnum;
use App\Http\Requests\API\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;

class RegisterController
{
    public function __invoke(RegisterRequest $registerRequest)
    {
        $user = User::create([
            'name' => $registerRequest->input('name'),
            'email' => $registerRequest->input('email'),
            'password' => bcrypt($registerRequest->input('password')),
        ]);

        event(new Registered($user));

        return Response::success(
            [],
            '',
            ResponseCodeEnum::SERVICE_REGISTER_SUCCESS
        );
    }
}
