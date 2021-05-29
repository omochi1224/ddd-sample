<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use Auth\Domain\Exception\UserNotFoundException;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Auth\Domain\Services\UserPasswordHasher;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Auth\Infrastructure\Repositories\Eloquent\EloquentUserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_保存()
    {
        $eloquent = new EloquentUser();

        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->make());

        $repository = new EloquentUserRepository($eloquent);
        $repository->store($dummyUserDomain);

        $dbUser = $eloquent->where('id', $dummyUserDomain->getUserId()->value())->first();

        self::assertEquals($dummyUserDomain->getUserId()->value(), $dbUser->id);
        self::assertEquals($dummyUserDomain->getUserEmail()->value(), $dbUser->email);
        self::assertEquals($dummyUserDomain->getUserName()->value(), $dbUser->name);

        $hasher = app(UserPasswordHasher::class);
        self::assertTrue($hasher->check('password', UserPassword::of($dbUser->password)));
    }

    public function test_IDで検索()
    {
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->create());

        $eloquent = new EloquentUser();
        $repository = new EloquentUserRepository($eloquent);
        $userDomain = $repository->findById($dummyUserDomain->getUserId());

        self::assertTrue($dummyUserDomain->getUserId()->equals($userDomain->getUserId()));
        self::assertTrue($dummyUserDomain->getUserName()->equals($userDomain->getUserName()));
        self::assertTrue($dummyUserDomain->getUserEmail()->equals($userDomain->getUserEmail()));
        self::assertTrue($dummyUserDomain->getUserPassword()->equals($userDomain->getUserPassword()));

        //存在しないユーザIDでの検索の場合はNullが返ってくることを確認
        unset($userDomain);
        $userDomain = $repository->findById(UserId::of(UserId::generate()));
        self::assertNull($userDomain);
    }

    public function test_メールアドレスで検索()
    {
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->create());

        $eloquent = new EloquentUser();
        $repository = new EloquentUserRepository($eloquent);
        $userDomain = $repository->findByEmail($dummyUserDomain->getUserEmail());

        self::assertTrue($dummyUserDomain->getUserId()->equals($userDomain->getUserId()));
        self::assertTrue($dummyUserDomain->getUserName()->equals($userDomain->getUserName()));
        self::assertTrue($dummyUserDomain->getUserEmail()->equals($userDomain->getUserEmail()));
        self::assertTrue($dummyUserDomain->getUserPassword()->equals($userDomain->getUserPassword()));

        unset($userDomain);
        $userDomain = $repository->findByEmail(UserEmail::of($this->faker->email));
        self::assertNull($userDomain);
    }

    public function test_削除()
    {
        /** @var \Auth\Domain\Models\User\User $dummyUserDomain */
        $dummyUserDomain = UserFactory::db(factory(EloquentUser::class)->create());

        $eloquent = new EloquentUser();
        $repository = new EloquentUserRepository($eloquent);
        $repository->delete($dummyUserDomain->getUserId());

        $dbUser = $eloquent->where('id', $dummyUserDomain->getUserId()->value())->first();
        self::assertNull($dbUser);

        //存在しないユーザを削除しようとすると例外が発生することを確認
        $this->expectException(UserNotFoundException::class); //発生が想定される例外
        $repository->delete(UserId::of(UserId::generate()));
    }
}
