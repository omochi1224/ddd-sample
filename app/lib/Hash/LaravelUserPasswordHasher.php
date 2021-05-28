<?php

declare(strict_types=1);

namespace App\lib\Hash;

use Auth\Domain\Models\User\User;
use Auth\Domain\Models\User\ValueObject\UserPassword;
use Auth\Domain\Services\UserPasswordHasher;
use Illuminate\Hashing\BcryptHasher;

final class LaravelUserPasswordHasher implements UserPasswordHasher
{
    /**
     * @var \Illuminate\Hashing\BcryptHasher
     */
    private BcryptHasher $hasher;

    /**
     * UserPasswordHasher constructor.
     */
    public function __construct()
    {
        $this->hasher = new BcryptHasher();
    }

    /**
     * @param string                        $password
     * @param \Auth\Domain\Models\User\User $user
     *
     * @return boolean
     */
    public function checkByUser(string $password, User $user): bool
    {
        return $this->check($password, $user->getUserPassword());
    }

    /**
     * @param string                                            $password
     * @param \Auth\Domain\Models\User\ValueObject\UserPassword $hash
     *
     * @return boolean
     */
    public function check(string $password, UserPassword $hash): bool
    {
        return $this->hasher->check($password, $hash->value());
    }

    /**
     * @param string $password
     *
     * @return \Auth\Domain\Models\User\ValueObject\UserPassword
     */
    public function make(string $password): UserPassword
    {
        return UserPassword::of($this->hasher->make($password));
    }
}
