<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

use Auth\Domain\Exception\UserNotFoundException;
use Auth\Domain\Models\User\ValueObject\UserEmail;
use Auth\Domain\Models\User\ValueObject\UserId;

/**
 * Interface UserRepository
 *
 * @package Auth\Domain\Models\User
 */
interface UserRepository
{
    /**
     * @param User $user
     *
     * @return void
     */
    public function store(User $user): void;

    /**
     * @param UserId $userId
     *
     * @return User|null
     */
    public function findById(UserId $userId): ?User;

    /**
     * @param UserEmail $userEmail
     *
     * @return User|null
     */
    public function findByEmail(UserEmail $userEmail): ?User;

    /**
     * @param UserId $userId
     *
     * @return void
     * @throws UserNotFoundException
     */
    public function delete(UserId $userId): void;
}
