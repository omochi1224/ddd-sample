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

    protected function setUp(): void
    {
        $this->hasher = app(UserPasswordHasher::class);
        parent::setUp();
    }

    public function test_make()
    {
        $userHashPassword = $this->hasher->make($this->password);
        self::assertNotEquals($this->password, $userHashPassword->value());
    }

    public function test_check()
    {
        //ハッシュ化パスワード
        $password = ['password' => $this->hasher->make($this->password)->value()];
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->make($password));

        self::assertTrue(
            $this->hasher->check($this->password, $dummyUserDomain->getUserPassword())
        );
    }

    public function test_checkByUser()
    {
        //ハッシュ化パスワード
        $password = ['password' => $this->hasher->make($this->password)->value()];
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->make($password));

        self::assertTrue($this->hasher->checkByUser($this->password, $dummyUserDomain));
    }
}
