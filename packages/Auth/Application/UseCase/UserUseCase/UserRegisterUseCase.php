<?php

declare(strict_types=1);

namespace Auth\Application\UseCase\UserUseCase;

use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResult;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Services\UserService;
use Basic\Transaction\Transaction;

/**
 * Class UserRegisterUseCase
 *
 * @package Auth\Application\UseCase
 */
final class UserRegisterUseCase
{
    /**
     * UserRegisterUseCase constructor.
     *
     * @param UserRepository $userRepository
     * @param Transaction    $transaction
     * @param UserService    $userService
     */
    public function __construct(
        private UserRepository $userRepository,
        private Transaction $transaction,
        private UserService $userService,
    ) {
    }

    /**
     * @param User $user
     *
     * @return UserUseCaseResult
     */
    public function invoke(User $user): UserUseCaseResult
    {
        return $this->transaction->scope(
            function () use ($user): UserUseCaseResult {
                //重複チェック
                if ($this->userService->isDuplicated($user)) {
                    return UserUseCaseResult::fail(UserUseCaseResultError::DUPLICATION_EMAIL());
                }

                //パスワード変更済みUser Domain
                $passwordEncryptionUserDomain = $this->userService->passwordHaher($user);

                //永続化処理
                $this->userRepository->store($passwordEncryptionUserDomain);

                return UserUseCaseResult::success(
                    $this->userRepository->findById($passwordEncryptionUserDomain->getUserId())
                );
            }
        );
    }
}
