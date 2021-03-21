<?php

namespace App\Enums;
use Jiannei\Enum\Laravel\Repositories\Enums\HttpStatusCodeEnum;

class ResponseCodeEnum extends HttpStatusCodeEnum
{
    // Correct code for business operations: start with 1xx, 2xx, 3xx, and splice 3 digits afterwards
    // 200 + 001 => 200001, that is, there are 001 ~ 999 numbers that can be used to indicate the success of the business. Of course, you can continue to increase the number of digits according to actual needs, but it must start with 200
    // Take a chestnut: You can define 001 ~ 099 to represent the system status; 100 ~ 199 to represent authorized services; 200 to 299 to represent user services...
    const SERVICE_REGISTER_SUCCESS = 200101;
    const SERVICE_LOGIN_SUCCESS = 200102;

    // Client error code: beginning with 400 ~ 499, splicing 3 digits afterwards
    const CLIENT_PARAMETER_ERROR = 400001;
    const CLIENT_CREATED_ERROR = 400002;
    const CLIENT_DELETED_ERROR = 400003;

    const CLIENT_VALIDATION_ERROR = 422001; // form validation error

    // Server operation error code: starting with 500 ~ 599, splicing 3 digits afterwards
    const SYSTEM_ERROR = 500001;
    const SYSTEM_UNAVAILABLE = 500002;
    const SYSTEM_CACHE_CONFIG_ERROR = 500003;
    const SYSTEM_CACHE_MISSED_ERROR = 500004;
    const SYSTEM_CONFIG_ERROR = 500005;

    // Business operation error code (external service or internal service call...)
    const SERVICE_REGISTER_ERROR = 500101;
    const SERVICE_LOGIN_ERROR = 500102;
}
