<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Factory;


use Auth\Domain\Models\User\UserFactory;
use Auth\Factory\UserDomainFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class UserFactoryTest extends TestCase
{
    use WithFaker;

    public function test_リクエスト()
    {
        $request = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ];

        /** @var UserDomainFactory $userFactory */
        $userFactory = app(UserFactory::class);
        $userDomain = $userFactory->request((object)$request);

        self::assertEquals($request['name'], $userDomain->getUserName()->value());
        self::assertEquals($request['password'], $userDomain->getUserPassword()->value());
        self::assertEquals($request['email'], $userDomain->getUserEmail()->value());
    }
}
