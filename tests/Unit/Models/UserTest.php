<?php

namespace Tests\Unit\Models;

use App\Models\NewAccessToken;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tests\TestCase;

class UserTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_it_has_many_refresh_token()
    {
        refreshToken::factory()->create(['tokenable_id' => $this->user->id]);
        $this->assertInstanceOf(MorphMany::class, $this->user->refreshTokens());
        $this->assertNotNull($this->user->refreshTokens);

        RefreshToken::factory()->create(['tokenable_id' => $this->user->id]);
        $this->assertEquals(2, $this->user->refreshTokens()->count());
    }

    public function test_it_can_create_refresh_token()
    {
        $refreshToken = $this->user->createRefreshToken();

        $this->assertInstanceOf(NewAccessToken::class, $refreshToken);
        $this->assertEquals(1, $this->user->refreshTokens()->count());
    }
}
