<?php

declare(strict_types=1);

namespace Auth\Domain\Models\User;

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
     * @param \Auth\Domain\Models\User\User $user
     *
     * @return void
     */
    public function store(User $user): void;

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findById(UserId $userId): ?User;

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserEmail $userEmail
     *
     * @return \Auth\Domain\Models\User\User|null
     */
    public function findByEmail(UserEmail $userEmail): ?User;

    /**
     * @param \Auth\Domain\Models\User\ValueObject\UserId $userId
     *
     * @return void
     * @throws \Auth\Domain\Exception\UserNotFoundException
     */
    public function delete(UserId $userId): void;
}
