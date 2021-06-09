<?php

declare(strict_types=1);

namespace Auth\Domain\Services;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\ValueObject\UserPassword;

/**
 * Class UserPasswordHasher
 *
 * @package Auth\Domain\Services
 */
interface UserPasswordHasher
{
    /**
     * @param string $password
     * @param User   $user
     *
     * @return boolean
     */
    public function checkByUser(string $password, User $user): bool;

    /**
     * @param string       $password
     * @param UserPassword $hash
     *
     * @return boolean
     */
    public function check(string $password, UserPassword $hash): bool;

    /**
     * @param string $password
     *
     * @return UserPassword
     */
    public function make(string $password): UserPassword;
}
