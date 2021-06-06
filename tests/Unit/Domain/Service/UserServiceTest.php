<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Service;


use Auth\Domain\Exception\UserIdDuplicationException;
use Auth\Domain\Exception\UserPasswordHaherException;
use Auth\Domain\Models\User\UserFactory;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Services\UserService;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Tests\TestCase;

final class UserServiceTest extends TestCase
{
    public function test_ID重複チェック()
    {
        /** @var UserFactory $factory */
        $factory = app(UserFactory::class);
        $dummyUser = $factory->db(factory(EloquentUser::class)->make());

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findByEmail')->andReturn(null);
        $repositoryMock->shouldReceive('findById')->andReturn($dummyUser);
        $this->app->instance(UserRepository::class, $repositoryMock);

        /** @var UserService $domainService */
        $domainService = app(UserService::class);
        //発生するべき例外
        $this->expectException(UserIdDuplicationException::class);
        $domainService->isDuplicated($dummyUser);
    }

    public function test_EMAIL重複チェック()
    {
        /** @var UserFactory $factory */
        $factory = app(UserFactory::class);
        $dummyUser = $factory->db(factory(EloquentUser::class)->make());

        //リポジトリのモック
        $repositoryMock = \Mockery::mock(UserRepository::class);
        $repositoryMock->shouldReceive('findById')->andReturn(null);
        $repositoryMock->shouldReceive('findByEmail')->andReturn($dummyUser);
        $this->app->instance(UserRepository::class, $repositoryMock);

        /** @var UserService $domainService */
        $domainService = app(UserService::class);
        $result = $domainService->isDuplicated($dummyUser);
        self::assertTrue($result);
    }
}
