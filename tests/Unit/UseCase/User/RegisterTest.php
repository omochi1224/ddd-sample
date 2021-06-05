<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\User;


use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Application\UseCase\UserUseCase\UserRegisterUseCase;
use Auth\Domain\Exception\UserPasswordHaherException;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Auth\Domain\Services\UserPasswordHasher;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Tests\TestCase;

final class RegisterTest extends TestCase
{
    public function test_正常登録処理()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = app(UserFactory::class)->db($dummyUser);

        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);
        $result = $useCase->invoke($userDomain);

        self::assertFalse($result->isError());

        self::assertInstanceOf(User::class, $result->getResultValue());
    }

    public function test_同じメールアドレスが登録されている場合()
    {
        /** @var \Auth\Domain\Models\User\User $userDomain */
        $userDomain = app(UserFactory::class)->db(factory(EloquentUser::class)->make());

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn(null);
        $repositoryMock->shouldReceive('findByEmail')->andReturn($userDomain);
        $this->app->instance(UserRepository::class, $repositoryMock);

        /** @var \Auth\Domain\Models\User\User $newUserDomain */
        $newUserDomain = app(UserFactory::class)->db(factory(EloquentUser::class)->make(
            ['email' => $userDomain->getUserEmail()->value()]
        ));

        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);

        $result = $useCase->invoke($newUserDomain);

        self::assertTrue($result->isError());
        self::assertEquals(UserUseCaseResultError::DUPLICATION_EMAIL, $result->getErrorCode());
    }

    public function test_パスワードが適切に暗号化されなかった場合例外が返ってくることを確認()
    {
        $password = 'password';

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn(null);
        $repositoryMock->shouldReceive('findByEmail')->andReturn(null);
        $this->app->instance(UserRepository::class, $repositoryMock);

        //パスワード暗号化サービスのモック
        $passwordHasher = \Mockery::mock(UserPasswordHasher::class);
        $userPassword = UserPassword::of($password);
        $passwordHasher->shouldReceive('make')->andReturn($userPassword);
        $this->app->instance(UserPasswordHasher::class, $passwordHasher);


        /** @var UserRegisterUseCase $useCase */
        $useCase = app(UserRegisterUseCase::class);

        $userDomain = app(UserFactory::class)->db(factory(EloquentUser::class)->make(['password' => $password]));

        $this->expectException(UserPasswordHaherException::class);
        //処理結果オブジェクト
        $result = $useCase->invoke($userDomain);

    }
}
