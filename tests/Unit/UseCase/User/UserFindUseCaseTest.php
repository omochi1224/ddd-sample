<?php

declare(strict_types=1);

namespace Tests\Unit\UseCase\User;


use Auth\Application\Dto\UserDto;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Application\UseCase\UserUseCase\UserFindUseCase;
use Auth\Domain\Models\User\UserQueryService;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Models\User\ValueObject\UserId;
use Auth\Infrastructure\Eloquent\EloquentUser;
use Tests\TestCase;

final class UserFindUseCaseTest extends TestCase
{
    public function test_invoke()
    {
        $dummyUser = factory(EloquentUser::class)->make();

        $dummyUserDto = new UserDto($dummyUser->id, $dummyUser->name, $dummyUser->email);

        //クエリサービスのモック
        $queryServiceMock = \Mockery::mock(UserQueryService::class);
        $queryServiceMock->shouldReceive('invoke')->andReturn([$dummyUserDto]);
        $this->app->instance(UserQueryService::class, $queryServiceMock);

        /** @var UserFindUseCase $useCase */
        $useCase = app(UserFindUseCase::class);

        $result = $useCase->invoke($dummyUser->id);

        //処理にエラーがないことを確認
        self::assertFalse($result->isError());
    }

    public function test_検索の結果がNOTFOUNDになることを確認()
    {

        //クエリサービスのモック
        $queryServiceMock = \Mockery::mock(UserQueryService::class);
        $queryServiceMock->shouldReceive('invoke')->andReturn([]);
        $this->app->instance(UserQueryService::class, $queryServiceMock);

        /** @var UserFindUseCase $useCase */
        $useCase = app(UserFindUseCase::class);

        $result = $useCase->invoke(UserId::generate());

        //処理にエラーになることを確認
        self::assertTrue($result->isError());

        //想定されているエラーが出ているか確認
        self::assertEquals(UserUseCaseResultError::NOT_FOUND, $result->getErrorCode());
    }
}
