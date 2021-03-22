<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\API\RegisterController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /** @test */
    public function a_user_can_register()
    {
        Hash::shouldReceive('make')
            ->once()
            ->with('password')
            ->andReturn('hashed');

        Event::fake();

        $this->postJson(action(RegisterController::class), [
                'name' => 'Test User',
                'email' => 'test@test.app',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@test.app',
            'password' => 'hashed',
        ]);

        Event::assertDispatched(Registered::class);
    }
}
