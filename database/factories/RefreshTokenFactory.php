<?php

namespace Database\Factories;

use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RefreshTokenFactory extends Factory
{
    protected $model = RefreshToken::class;

    public function definition()
    {
        return [
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'expires_at' => now()->addDays(7),
            'tokenable_id' => User::factory(),
            'tokenable_type' => (new User())->getMorphClass(),
        ];
    }

    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => now()->subDay(),
            ];
        });
    }
}
