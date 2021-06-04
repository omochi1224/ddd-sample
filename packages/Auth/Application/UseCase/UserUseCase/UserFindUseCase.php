<?php

declare(strict_types=1);

namespace Auth\Application\UseCase\UserUseCase;

use Auth\Application\Dto\UserDto;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResult;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Domain\Models\User\UserQueryService;

/**
 * Class UserFindUseCase
 *
 * @package Auth\Application\UseCase\UserUseCase
 */
final class UserFindUseCase
{
    /**
     * UserFindUseCase constructor.
     *
     * @param \Auth\Domain\Models\User\UserQueryService $queryService
     */
    public function __construct(private UserQueryService $queryService)
    {
    }

    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $email
     *
     * @return \Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResult
     */
    public function invoke(?string $id = null, ?string $name = null, ?string $email = null): UserUseCaseResult
    {
        $queryData = $this->queryService->invoke($id, $name, $email);

        $array = array_map(
            function (UserDto $dto) {
                return ['id' => $dto->getId(), 'name' => $dto->getName(), 'email' => $dto->getEmail()];
            },
            $queryData
        );

        if (count($array) === 0) {
            return UserUseCaseResult::fail(UserUseCaseResultError::NOT_FOUND);
        }

        return UserUseCaseResult::success((object)$array);
    }
}
