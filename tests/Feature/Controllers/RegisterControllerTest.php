<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\API\RegisterController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    /** @test */
    public function a_user_can_register()
    {
        Event::fake();

        $this->postJson(action(RegisterController::class), [
                'name' => 'Test User',
                'email' => 'test@test.app',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertSuccessful();

        Event::assertDispatched(Registered::class);
    }
}
