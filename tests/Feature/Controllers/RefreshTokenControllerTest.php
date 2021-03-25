<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\API\RefreshTokenController;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class RefreshTokenControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_throw_exception_if_not_provide()
    {
        $this
            ->postJson(action(RefreshTokenController::class), )
            ->assertStatus(401);
    }

    public function test_unauthorized_if_provide_invalid_token()
    {
        $this->disableCookieEncryption();

        $this
            ->withCookie('refresh_token', 'invalid_token')
            ->withCredentials()
            ->postJson(action(RefreshTokenController::class))
            ->assertStatus(401);

        $expiredToken = RefreshToken::factory()->expired()->create([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ]);

        $plainExpiredTextToken = $expiredToken->getKey().'|'.$plainTextToken;

        $this
            ->withCookie('refresh_token', $plainExpiredTextToken)
            ->withCredentials()
            ->postJson(action(RefreshTokenController::class))
            ->assertStatus(401);

        $notExistsTokenable = $this->user->createRefreshToken()->plainTextToken;
        $this->user->delete();

        $this->assertDeleted($this->user);

        $this
            ->withCookie('refresh_token', $notExistsTokenable)
            ->withCredentials()
            ->postJson(action(RefreshTokenController::class))
            ->assertStatus(401);
    }

    public function test_it_can_refresh_token()
    {
        $this->disableCookieEncryption();

        $refreshToken = $this->user->createRefreshToken()->plainTextToken;

        $this
            ->withCookie('refresh_token', $refreshToken)
            ->withCredentials()
            ->postJson(action(RefreshTokenController::class))
            ->assertSuccessful();
    }
}
