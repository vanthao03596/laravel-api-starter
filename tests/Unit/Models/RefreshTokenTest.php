<?php

namespace Tests\Unit\Models;

use App\Models\NewAccessToken;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\TestCase;

class RefreshTokenTest extends TestCase
{
    /** @test */
    public function a_refresh_token_belongs_to_tokenable()
    {
        $refreshToken = RefreshToken::factory()->create();

        $this->assertInstanceOf(User::class, $refreshToken->tokenable);
    }

    /** @test */
    public function it_can_check_expired()
    {
        $notExpiredRefreshToken = RefreshToken::factory()->create();

        $this->assertFalse($notExpiredRefreshToken->isExpired());

        $expiredRefreshToken = RefreshToken::factory()->expired()->create();

        $this->assertTrue($expiredRefreshToken->isExpired());
    }
}
