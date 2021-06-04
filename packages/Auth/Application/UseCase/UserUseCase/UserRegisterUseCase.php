<?php

declare(strict_types=1);

namespace Auth\Application\UseCase\UserUseCase;

use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResult;
use Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResultError;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserRepository;
use Auth\Domain\Services\UserPasswordHasher;
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
     * @param \Auth\Domain\Models\User\UserRepository  $userRepository
     * @param \Basic\Transaction\Transaction           $transaction
     * @param \Auth\Domain\Services\UserPasswordHasher $userPasswordHasher
     */
    public function __construct(
        private UserRepository $userRepository,
        private Transaction $transaction,
        private UserPasswordHasher $userPasswordHasher
    ) {
    }

    /**
     * @param \Auth\Domain\Models\User\User $user
     *
     * @return \Auth\Application\UseCase\UserUseCase\Result\UserUseCaseResult
     */
    public function invoke(User $user): UserUseCaseResult
    {
        return $this->transaction->scope(
            function () use ($user): UserUseCaseResult {
                //ID重複チェック
                $existsId = $this->userRepository->findById($user->getUserId());
                if (!is_null($existsId)) {
                    return UserUseCaseResult::fail(UserUseCaseResultError::DUPLICATION_ID);
                }

                //メールアドレス重複チェック
                $existsEmail = $this->userRepository->findByEmail($user->getUserEmail());
                if (!is_null($existsEmail)) {
                    return UserUseCaseResult::fail(UserUseCaseResultError::DUPLICATION_EMAIL);
                }

                //パスワード暗号化
                $encryptionUserPassword = $this->userPasswordHasher->make($user->getUserPassword()->value());

                //パスワードがHash化されたことを確認
                if ($user->getUserPassword()->equals($encryptionUserPassword)) {
                    return UserUseCaseResult::fail(UserUseCaseResultError::PASSWORD_ENCRYPT);
                }

                //暗号化パスワードに変更
                $user->changePassword($encryptionUserPassword);

                //永続化処理
                $this->userRepository->store($user);

                return UserUseCaseResult::success(
                    $this->userRepository->findById($user->getUserId())
                );
            }
        );
    }
}
