<?php

namespace App\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class NewAccessToken implements Arrayable, Jsonable
{
    public RefreshToken $refreshToken;

    public string $plainTextToken;

    public function __construct(RefreshToken $refreshToken, string $plainTextToken)
    {
        $this->refreshToken = $refreshToken;
        $this->plainTextToken = $plainTextToken;
    }

    public function toArray(): array
    {
        return [
            'refreshToken' => $this->refreshToken,
            'plainTextToken' => $this->plainTextToken,
        ];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
