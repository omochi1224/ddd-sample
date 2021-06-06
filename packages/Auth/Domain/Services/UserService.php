<?php

declare(strict_types=1);

namespace Auth\Domain\Services;

use Auth\Domain\Exception\UserIdDuplicationException;
use Auth\Domain\Exception\UserPasswordHaherException;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserRepository;

/**
 * ユーザドメインに入り込めないコード
 *
 * Class UserService
 *
 * @package Auth\Domain\Services
 */
final class UserService
{
    /**
     * UserService constructor.
     *
     * @param \Auth\Domain\Services\UserPasswordHasher $passwordHasher
     * @param \Auth\Domain\Models\User\UserRepository  $userRepository
     */
    public function __construct(
        private UserPasswordHasher $passwordHasher,
        private UserRepository $userRepository,
    ) {
    }

    /**
     * ユーザの重複チェック
     *
     * @param \Auth\Domain\Models\User\User $user
     *
     * @return boolean
     * @throws \Auth\Domain\Exception\UserIdDuplicationException
     */
    public function isDuplicated(User $user): bool
    {
        /** ユーザエラー */
        if ($this->userRepository->findByEmail($user->getUserEmail()) !== null) {
            return true;
        }

        /** システムエラー */
        if ($this->userRepository->findById($user->getUserId()) !== null) {
            throw new UserIdDuplicationException();
        }

        return false;
    }

    /**
     * パスワード暗号化
     *
     * @param \Auth\Domain\Models\User\User $user
     *
     * @return \Auth\Domain\Models\User\User
     * @throws \Auth\Domain\Exception\UserPasswordHaherException
     */
    public function passwordHaher(User $user): User
    {
        $encryptionUserPassword = $this->passwordHasher->make($user->getUserPassword()->value());
        //パスワードがHash化されたことを確認
        if ($user->getUserPassword()->equals($encryptionUserPassword)) {
            throw new UserPasswordHaherException('パスワードの暗号化ができませんでした。');
        }

        $user->changePassword($encryptionUserPassword);
        return $user;
    }
}
