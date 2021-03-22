<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\API\AuthorizationController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorizationControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function a_user_can_login()
    {
        $this
            ->postJson(action([AuthorizationController::class, 'store']), [
                'email'    => $this->user->email,
                'password' => 'password',
            ])
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'token_type' => 'bearer'
                ]
            ]);
    }

    /** @test */
    public function fetch_the_current_user()
    {
        $this->actingAs($this->user)
            ->getJson(action([AuthorizationController::class, 'show']))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                ]
            ])
            ->assertJson([
                'data' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ]
            ]);
    }

    /** @test */
    public function a_user_can_logout()
    {
        $token = $this->postJson(action([AuthorizationController::class, 'store']), [
            'email'    => $this->user->email,
            'password' => 'password',
        ])->json()['data']['access_token'];

        $this->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])
            ->deleteJson(action([AuthorizationController::class, 'destroy']))
            ->assertSuccessful();

        $this->getJson(action([AuthorizationController::class, 'show']))
            ->assertStatus(401);
    }
}
