<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class RegisterControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_登録()
    {
        $requestData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $pass = $this->faker->password,
            'password_confirmation' => $pass,
        ];

        $response = $this->post(route('user.register'), $requestData);
        $response->assertOk();

        unset($requestData['password']);
        unset($requestData['password_confirmation']);

        $response->assertJsonFragment($requestData);
    }
}
