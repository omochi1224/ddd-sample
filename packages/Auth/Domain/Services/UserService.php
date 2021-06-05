<?php

declare(strict_types=1);

namespace Auth\Domain\Services;


use Auth\Domain\Exception\UserIdDuplicationException;
use Auth\Domain\Exception\UserPasswordHaherException;
use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\UserRepository;

/**
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
     * @return bool
     * @throws \Auth\Domain\Exception\UserIdDuplicationException
     */
    public function isDuplicated(User $user): bool
    {
        if (!is_null($this->userRepository->findByEmail($user->getUserEmail()))) {
            return true;
        }

        if (!is_null($this->userRepository->findById($user->getUserId()))) {
            throw new UserIdDuplicationException();
        }

        return false;
    }

    /**
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
