<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\User;


use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Application\UseCase\UserUseCase\UserRegisterUseCase;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\UserRepository;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Tests\TestCase;

final class RegisterTest extends TestCase
{
    public function test_正常登録処理()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = UserFactory::db($dummyUser);

        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);
        $result = $useCase->invoke($userDomain);

        self::assertFalse($result->isError());

        self::assertInstanceOf(User::class, $result->getResultValue());
    }

    public function test_同じIDが登録されている場合()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = UserFactory::db($dummyUser);

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')
        ->andReturn($userDomain);
        $this->app->instance(UserRepository::class, $repositoryMock);

        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);

        $result = $useCase->invoke($userDomain);

        //エラーのがあるかどうか
        self::assertTrue($result->isError());
        self::assertEquals(UserUseCaseResultError::DUPLICATION_ID, $result->getErrorCode());
    }

    public function test_同じメールアドレスが登録されている場合()
    {

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = UserFactory::db(factory(EloquentUser::class)->make());

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn(null);
        $repositoryMock->shouldReceive('findByEmail')->andReturn($userDomain);
        $this->app->instance(UserRepository::class, $repositoryMock);

        /** @var \Auth\Domain\Models\User\User $newUserDomain */
        $newUserDomain = UserFactory::db(factory(EloquentUser::class)->make(
            ['email' => $userDomain->getUserEmail()->value()]
        ));

        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);

        $result = $useCase->invoke($newUserDomain);

        self::assertTrue($result->isError());
        self::assertEquals(UserUseCaseResultError::DUPLICATION_EMAIL, $result->getErrorCode());
    }
}
