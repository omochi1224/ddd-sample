<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\UserRepository;
use Auth\Infrastructure\Eloquent\EloquentUser;
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
            'password' => $pass = $this->faker->password(10),
            'password_confirmation' => $pass,
        ];

        $response = $this->post(route('user.register'), $requestData);
        $response->assertOk();

        unset($requestData['password']);
        unset($requestData['password_confirmation']);

        $response->assertJsonFragment($requestData);
    }

    public function test_バリデーションエラー()
    {
        $requestData = [
            'name' => $this->faker->name,
            'email' => 'error',
            'password' => $pass = $this->faker->password(10),
            'password_confirmation' => $pass,
        ];

        $response = $this->post(route('user.register'), $requestData);
        $response->assertStatus(422);

        $response->assertJsonFragment(['errors' => ['email' => ['The email must be a valid email address.']]]);
    }

    public function test_ID重複登録エラー()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = app(UserFactory::class)->db($dummyUser);

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn($userDomain);
        $this->app->instance(UserRepository::class, $repositoryMock);

        $requestData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $pass = $this->faker->password(10),
            'password_confirmation' => $pass,
        ];

        $response = $this->post(route('user.register'), $requestData);

        $response->assertStatus(500);
    }

    public function test_メールアドレス重複登録エラー()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = app(UserFactory::class)->db($dummyUser);

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn(null);
        $repositoryMock->shouldReceive('findByEmail')->andReturn($userDomain);
        $this->app->instance(UserRepository::class, $repositoryMock);

        $requestData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $pass = $this->faker->password(10),
            'password_confirmation' => $pass,
        ];

        $response = $this->post(route('user.register'), $requestData);

        $response->assertStatus(409);

        $errorResponse = ['errors' => ['message' => 'すでに登録済みのメールアドレスです']];
        $response->assertJsonFragment($errorResponse);
    }
}
