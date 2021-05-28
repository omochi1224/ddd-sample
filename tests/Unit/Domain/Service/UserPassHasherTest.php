<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Service;


use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Services\UserPasswordHasher;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Tests\TestCase;

/**
 * @property \Auth\Domain\Services\UserPasswordHasher hasher
 */
final class UserPassHasherTest extends TestCase
{
    private string $password = 'paAssw0rd!';

    public function test_make()
    {
        $hasher = app(UserPasswordHasher::class);
        $userHashPassword = $hasher->make($this->password);
        self::assertNotEquals($this->password, $userHashPassword->value());
    }

    public function test_check()
    {
        $hasher = app(UserPasswordHasher::class);

        //ハッシュ化パスワード
        $password = ['password' => $hasher->make($this->password)->value()];
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->make($password));
        self::assertTrue($hasher->check($this->password, $dummyUserDomain->getUserPassword()));
    }

    public function test_checkByUser()
    {
        $hasher = app(UserPasswordHasher::class);

        //ハッシュ化パスワード
        $password = ['password' => $hasher->make($this->password)->value()];
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->make($password));

        self::assertTrue($hasher->checkByUser($this->password, $dummyUserDomain));
    }
}
