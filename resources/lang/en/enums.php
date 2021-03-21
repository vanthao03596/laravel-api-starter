<?php

use App\Enums\ResponseCodeEnum;

return [
    ResponseCodeEnum::class => [
        // Success
        ResponseCodeEnum::HTTP_OK => 'Success.', // Custom HTTP status code return message
        ResponseCodeEnum::HTTP_UNAUTHORIZED => 'Unauthorized.',

        // Successful business operation
        ResponseCodeEnum::SERVICE_REGISTER_SUCCESS => 'Register success.',
        ResponseCodeEnum::SERVICE_LOGIN_SUCCESS => 'Login success.',

        // Client error
        ResponseCodeEnum::CLIENT_PARAMETER_ERROR => 'Parameter error.',
        ResponseCodeEnum::CLIENT_CREATED_ERROR => 'Created error.',
        ResponseCodeEnum::CLIENT_DELETED_ERROR => 'Deleted error.',

        // Server error
        ResponseCodeEnum::SYSTEM_ERROR => 'System error.',
        ResponseCodeEnum::SYSTEM_UNAVAILABLE => 'System unavailable.',

        // Business operation failed: authorized business
        ResponseCodeEnum::SERVICE_REGISTER_ERROR => 'Register error.',
        ResponseCodeEnum::SERVICE_LOGIN_ERROR => 'Login error,',
    ],
];
